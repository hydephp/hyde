# HydePHP Code Review Rules

Use these rules when reviewing HydePHP changes.

The goal is not to find the maximum possible number of issues. The goal is to identify **real bugs, regressions, public-contract problems, footguns, and missing coverage without expanding the implementation beyond what the feature actually needs**.

## 1. Review for real risk, not theoretical completeness

Prioritize issues that can realistically affect:

* existing HydePHP users,
* documented or intentionally supported APIs,
* normal framework extension points,
* expected Laravel-style usage,
* build output,
* routing,
* serving,
* configuration,
* upgrade paths.

Do not turn every technically possible input into a compatibility requirement.

Before raising an edge case, ask:

1. Is this behavior documented?
2. Is it intentionally supported?
3. Is it a natural use of the API?
4. Could existing users reasonably rely on it?
5. Does fixing it simplify the model, or add machinery solely for the edge case?

If the answer is mostly no, do not recommend architectural changes for it.

## 2. Distinguish invariants from edge cases

A missing case is worth fixing when it exposes a contradiction in a rule the framework already claims.

For example, if the contract is:

> Explicit `InMemoryPage` identifier extensions win, and only `.html` is implicit in route keys.

then `users.html` on a `.json`-configured subclass is worth checking because it completes that invariant.

That is different from inventing support for an unusual configuration merely because the old implementation happened to accept it.

Review the **rule**, not an endless matrix of examples.

Once representative cases prove the invariant, stop.

## 3. Prefer the smallest fix that makes the model coherent

A good fix should usually make the existing rule more consistent.

Prefer:

* one corrected condition,
* one existing extension point,
* one narrowly scoped branch,
* one representative regression test.

Be suspicious of fixes that introduce:

* new public APIs,
* flags,
* factories,
* wrapper classes,
* special page types,
* duplicated configuration,
* compatibility shims,
* additional lifecycle concepts,

unless those things solve a real user problem that cannot cleanly fit the current model.

Do not create infrastructure to support a hypothetical edge case.

## 4. Do not let code review create scope creep

Every proposed review fix must be checked against the feature's original scope.

Ask:

> If this issue had been noticed during initial design, would we actually have considered it part of this feature?

If not, it probably belongs in a separate issue or nowhere at all.

A review finding is not automatically a requirement.

Explicitly call out when a proposed fix is becoming larger or riskier than the problem it solves.

## 5. Protect public contracts aggressively

Be strict about behavior users can intentionally rely on.

Review:

* public methods and properties,
* configuration keys,
* documented front matter,
* route semantics,
* output paths,
* extension points,
* service-container bindings,
* user-defined page overrides,
* command behavior,
* documented upgrade paths.

If two parts of the public API can produce contradictory results, that is a real bug even if the input is uncommon.

Examples:

* route key and output path disagree,
* static and instance resolution disagree,
* docs say an override works but implementation ignores it,
* configuration says “filename” but implementation silently interprets it differently,
* a supported extension point is bypassed by new framework code.

## 6. Do not preserve accidental behavior automatically

Backward compatibility applies to meaningful behavior, not every implementation accident.

Before demanding compatibility, determine whether the old behavior was:

* documented,
* tested intentionally,
* exposed as public API,
* a plausible user customization,
* or merely something the implementation technically allowed.

Do not add complexity solely to preserve undocumented pathological states.

If compatibility would require disproportionate machinery, prefer either:

* allowing the clean v3 behavior,
* documenting the breaking change if realistically relevant,
* or leaving the unusual case unsupported until there is evidence of demand.

## 7. Prefer existing HydePHP and Laravel concepts

Do not invent abstractions when an existing framework concept already expresses the behavior.

Prefer:

* page classes,
* normal route keys,
* `InMemoryPage`,
* service-container rebinding,
* configuration,
* front matter,
* Hyde extensions,
* lifecycle callbacks,
* ordinary Laravel conventions.

The common case should remain obvious.

Advanced behavior can use existing extension points without making the basic API more complicated.

## 8. Be especially suspicious of special-case machinery

A special case may be justified when it directly represents an existing public rule.

A special case is suspicious when it exists solely to rescue one obscure permutation.

For every special branch, ask:

> Is this representing an actual semantic distinction in the model, or compensating for an awkward example we discovered during review?

Keep the former. Avoid the latter.

## 9. Tests should prove rules, not enumerate combinations

Use tests at the layer where the behavior belongs.

A useful pattern is:

* unit test the core rule,
* feature test one representative end-to-end path when integration matters.

Do not test the same invariant at every layer unless each layer protects against a genuinely different regression.

Avoid Cartesian-product testing such as every combination of:

* extension,
* page subtype,
* command,
* build,
* serve,
* manifest,
* static helper,
* instance helper.

Tests should give confidence, not turn the implementation into a specification for every incidental permutation.

When removing redundant coverage, retain the tests that best explain and protect the contract.

## 10. End-to-end tests matter for integration boundaries

Use real feature tests when multiple systems interact, for example:

* configuration → page discovery → route → build output,
* page registration → command → generated file,
* route → realtime compiler → response,
* custom page override → normal build.

A unit test alone is insufficient when the risk is that individually correct pieces disagree when composed.

## 11. Do not add tests merely because a reviewer imagined a case

A newly imagined edge case should first pass the same relevance test as a code change.

If we decide the edge case is not part of the supported contract, do not immortalize it in tests.

Tests themselves create maintenance obligations and can accidentally turn implementation accidents into permanent API.

## 12. Documentation should cover the public contract, not implementation archaeology

Document:

* what users can do,
* important defaults,
* meaningful precedence rules,
* supported extension points,
* recommended customization paths,
* upgrade consequences.

Do not document:

* every internal execution consequence,
* rejected designs,
* implementation proof,
* container timing unless users need it,
* helper symmetry,
* every internal branch,
* obscure edge cases that users should not rely on.

A useful rule:

> Document the public contract once where users naturally look for it. Document migration consequences in `UPGRADE.md`. Do not document architecture merely because it is interesting.

But do not use this rule as an excuse to remove meaningful public behavior or recommended customization recipes.

## 13. Recommended customization paths must remain discoverable

If Hyde intentionally supports a customization mechanism, normal documentation should tell users about it.

For example:

* front matter for page-level behavior,
* overriding a page method for custom page classes,
* rebinding a generator for generated-content customization,
* registering a same-route page for complete replacement.

Do not replace useful guidance with vague statements such as “customize using the normal APIs.”

Conversely, do not turn those mechanisms into giant tutorials when a paragraph and small example are enough.

## 14. Upgrade notes should describe realistic impact

`UPGRADE.md` should tell users what they might actually need to change.

Be specific about:

* renamed public APIs,
* removed extension points,
* changed precedence,
* changed command behavior,
* custom code that may stop being called.

Do not prescribe migration work for scenarios nobody realistically relied on.

If a breaking change has no plausible real-world impact, say so rather than inventing a migration.

## 15. Generated documentation must describe actual guarantees

Be careful with wording such as:

* “includes”
* “always”
* “requires”
* “returns”

when the implementation does not enforce those statements.

Prefer wording such as:

> Output extensions should include the leading dot.

when the framework accepts the raw configured value rather than normalizing or validating it.

Documentation must not promise stronger invariants than the code provides.

## 16. Comments should be exceptional

Do not add comments that narrate readable code.

Comments/docblocks are justified for:

* public API documentation,
* static-analysis typing PHP cannot express,
* genuinely non-obvious constraints or compatibility requirements.

Before adding a comment, consider whether the code can instead be simplified.

Review-generated comments explaining why a patch is correct belong in the PR description, not the code.

## 17. Avoid speculative hardening

Do not add validation, normalization, error handling, abstraction, or compatibility logic merely because it could theoretically be useful.

Only harden something when there is a concrete failure mode worth protecting users from.

“Someone could configure this strangely” is not by itself enough.

## 18. Keep commits coherent and green

Final commit history should have meaningful, independently valid commits.

Do not leave a commit whose newly added tests intentionally fail until the following commit.

Prefer either:

* implementation + tests for one coherent behavior in the same commit, or
* separate commits only when each leaves the repository valid.

Do not split commits merely to make the history look more granular.

## 19. Review the full diff after local fixes

After fixing individual findings, re-review the complete diff for:

* temporary compatibility machinery,
* redundant tests,
* superseded code,
* stale documentation,
* duplicated explanations,
* old imports,
* abandoned design remnants,
* review-driven scope creep.

A sequence of individually reasonable review fixes can collectively make the final design worse.

The final review must therefore ask:

> Is the resulting implementation still simpler than the problem?

## 20. Know when to stop

Once:

* the public contract is coherent,
* realistic regressions are covered,
* the normal path is simple,
* extension points work,
* documentation is sufficient,
* upgrade consequences are recorded,

stop searching for additional permutations.

Do not continue generating edge cases just because another one can be imagined.

A review is successful when it increases confidence **without increasing accidental complexity**.

## Review output style

When reviewing a diff:

* Separate **real blockers** from optional observations.
* State clearly when something is correct and should not be changed.
* If a concern is speculative, label it as such.
* Explicitly identify suggestions that would be overengineering.
* Prefer “leave this alone” when the current implementation is already adequate.
* Do not recommend cleanup merely because code could be made theoretically more abstract.
* Re-evaluate your own previous suggestions when later context shows they created unnecessary complexity.

The standard is not “can this be made more robust?”

The standard is:

> **Is this the simplest implementation that correctly preserves the intended public contract and realistic user behavior?**
