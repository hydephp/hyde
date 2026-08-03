## HydePHP v3 working rules

You are working on the HydePHP v3 development branch. HydePHP v3 has not been released.

Before making changes, inspect the relevant code, tests, existing public documentation, upgrade guide, release notes, and `HYDEPHP_V3_PLANNING.md`. Do not make assumptions based only on the task description.

### Treat v3 as one unreleased change

Public documentation must describe the final difference between the latest released v2 version and the eventual v3 release.

Do not document the history of changes made between unreleased v3 branches or pull requests.

For example:

* v2 used Apple.
* An earlier v3 change replaced Apple with Banana.
* The current change replaces Banana with Orange.

The public release note must say that v3 changes Apple to Orange. It must not say that Banana was changed to Orange, because users have never received a version containing Banana.

Update or replace earlier unreleased documentation so the repository describes one coherent final v3 design. Pretend superseded v3 behaviour was never public.

Intermediate decisions, abandoned implementations, and design history may be preserved in `HYDEPHP_V3_PLANNING.md` when they remain useful as project memory. They do not belong in public documentation, upgrade guides, or release notes.

### Establish the public API boundary first

Before documenting anything, classify it as one of:

1. Public API or intentionally documented user-facing behaviour.
2. User-visible behaviour that requires an upgrade action.
3. Internal architecture or implementation detail.
4. Forgiving behaviour accepted for robustness but not intended as normal usage.

Only the first two categories normally belong in public documentation.

Internal classes, view models, rendering pipelines, helper methods, parser mechanics, adapters, refactors, implementation-specific terminology, and internal design decisions do not belong in public documentation merely because they changed.

A change is not part of the public API simply because its class or method is technically accessible. Consider whether it was intentionally supported, documented, and something users were expected to depend on.

Likewise, syntax is not necessarily part of the documented contract merely because the parser accepts it. Validation and parsing may deliberately tolerate unusual, incomplete, or non-canonical input to provide better compatibility or error handling. That does not make those forms recommended usage.

Release notes should explain meaningful user-facing changes.

Upgrade guides should explain actions users may need to take.

Normal documentation should describe the final supported behaviour and public API.

The v3 planning document may contain implementation rationale and project history.

### Document the intended path, not every accepted path

Documentation should teach users how they are supposed to use HydePHP, not enumerate every input the implementation happens to accept.

For each feature, identify its canonical usage and document that clearly. Examples must use the canonical syntax, naming, structure, and configuration.

Do not advertise parser tolerance, fallback behaviour, defensive compatibility, or incidental alternatives unless users genuinely need to know about them.

For example, if the intended code-block title syntax uses a language followed by a double-quoted title:

````markdown
```php title="hello-world.php"
echo 'Hello World!';
```
````

then document that form.

Do not add paragraphs explaining that single quotes also parse, that the language may be omitted, that malformed-looking forms fall back to plaintext, or that other unusual combinations happen to work unless one of those forms is intentionally recommended.

An implementation accepting something is not, by itself, a reason to put it in the manual. A test covering an edge case is not evidence that the edge case needs documentation.

Only document an alternative form when at least one of these is true:

* It is an intentional and recommended way to use the feature.
* Users must choose between the alternatives.
* Existing documented v2 usage depends on it.
* It prevents a realistic and otherwise likely mistake.
* It has meaningful consequences users need to understand.
* Omitting it would make the documented public contract misleading.

Robustness behaviour may still be tested thoroughly without being promoted as a feature.

Do not derive documentation mechanically from every branch, test case, accepted value, constructor parameter, or parser capability. Documentation is a curated description of intended use.

### Public documentation must remain proportional

Do not dump implementation details into `docs/`.

Documentation is not a development diary, pull-request description, exhaustive specification, or substitute for readable code. A small feature should receive a small amount of documentation.

Only include information that helps a framework user:

* Understand a supported feature.
* Use the public API correctly.
* Recognize a meaningful behaviour change.
* Upgrade existing documented usage.
* Avoid a realistic user-facing mistake.

Do not add paragraphs describing:

* Internal architecture or implementation mechanics.
* Minor markup details with no practical consequence.
* Every technically valid variation of a syntax.
* Defensive parser behaviour.
* Rare edge cases that users are not expected to encounter.
* Class relationships or internal data flow.
* Decisions that have no effect on how users work with HydePHP.
* Facts already made obvious by a clear example.
* Capabilities that are technically possible but not recommended.

Do not document something merely because it took effort to implement, required several tests, or appears in the diff.

Prefer the smallest amount of documentation that completely communicates the intended user-facing contract. Start with one clear explanation and one canonical example. Add more only when the user genuinely needs more to use the feature correctly.

Preserve the hierarchy of information so minor details do not drown out important behaviour. Do not give every edge case its own heading or paragraph.

Review all affected files in `docs/`, release notes, upgrade guides, examples, and relevant code comments. Update existing text rather than stacking contradictory, repetitive, or chronological notes on top of it.

### Avoid speculative completeness

Do not attempt to make documentation “complete” by listing every implication of the implementation.

Before adding a sentence, ask:

* Will this change how a normal user uses the feature?
* Is this the recommended way to use it?
* Would a user reasonably be confused without it?
* Is this fact more important than the additional reading burden it creates?

If the answer is no, omit it.

Do not pre-emptively document hypothetical questions, unusual combinations, future extension points, or behaviour discoverable only by deliberately pushing the implementation outside its intended use.

Do not turn implementation flexibility into a menu of public choices.

Prefer opinionated documentation. When HydePHP has a normal way to do something, show that way directly instead of presenting every accepted alternative as equally valid.

### Write in the existing HydePHP voice

Documentation must sound like it was written by the maintainer, not generated by an AI.

Use direct, natural, technically precise language. Avoid inflated explanations, repetitive summaries, excessive headings, fake enthusiasm, generic transitions, and statements that merely restate the code or preceding example.

Do not explain obvious output after showing a self-explanatory example.

Avoid phrases that call attention to the documentation itself, such as:

* “As you may have noticed…”
* “It is worth noting that…”
* “This powerful feature allows you to…”
* “Under the hood…”
* “For added flexibility…”

State the useful fact directly or omit it.

Do not use `docs/digging-deeper/composable-markdown-blocks.md` as a style or tone reference. Its current writing is known to be poor and will be fixed separately.

Use stronger existing HydePHP documentation as the style reference instead.

### Code comments are exceptional

Do not add comments that explain what readable code already says.

Code comments and docblocks should exist only for these reasons:

1. To provide useful static-analysis typing that PHP cannot otherwise express, such as generics or array shapes.
2. To document an intentional public API where the docblock forms part of generated or developer-facing API documentation.
3. To explain a genuinely non-obvious constraint, edge case, compatibility requirement, or design decision that cannot reasonably be made clear through better code.

Except for public API documentation, comments should explain why something must be done, never narrate what the code does.

Before adding a comment for unusual code, first determine whether the code can be simplified, renamed, extracted, or redesigned so the comment becomes unnecessary. A comment must not be used to excuse confusing code or avoid a refactor.

Keep necessary comments sparse and concise. Remove redundant comments introduced by the change.

Do not add comments merely to ensure every method, branch, property, or regex has an explanation.

### Implementation discipline

Prefer the simplest design that satisfies the current public contract and fits HydePHP’s existing architecture.

Do not introduce abstractions, extension points, configuration, public methods, public classes, compatibility layers, or documentation for hypothetical future requirements.

Do not expand the public API as a side effect of an internal refactor.

Do not preserve an earlier unreleased v3 implementation merely for compatibility. Nothing on the v3 branch is released unless the repository explicitly treats it as an established public contract.

It is acceptable for an implementation to be more forgiving than the public documentation. Keep that tolerance internal unless it becomes intentional recommended behaviour.

Tests should verify meaningful behaviour and regressions, not mirror every internal implementation detail. Edge-case tests may protect robustness without requiring matching documentation.

Refactors should be allowed to change internals without forcing unrelated test or documentation rewrites.

### Documentation review discipline

When documentation changes are needed:

1. Find the smallest existing location where the information belongs.
2. Edit the existing explanation rather than creating a parallel section.
3. Show the canonical usage.
4. Include only constraints users need in ordinary use.
5. Remove obsolete or now-redundant text.
6. Read the entire surrounding section to ensure the new text remains proportional.

Do not create a dedicated section merely because the implementation has a distinct feature name. A sentence or example in an existing section may be sufficient.

Do not add a “Usage,” “Behaviour,” “Details,” or “Notes” subsection unless the amount and importance of information genuinely justify it.

Do not repeat the same feature across normal documentation, an upgrade guide, release notes, and the planning document unless each location serves a distinct purpose:

* Normal documentation: how to use the final feature.
* Upgrade guide: what an existing user must change.
* Release notes: a concise summary of the meaningful v2-to-v3 difference.
* Planning document: internal design context and history.

### Commits

Create atomic commits.

Each commit should represent one coherent change and leave the repository in a valid state. Do not mix unrelated refactors, behaviour changes, generated assets, documentation cleanup, and bug fixes when they can be separated meaningfully.

Commit messages should explain the completed change, not narrate the editing process.

Before finishing, inspect the complete diff and remove temporary code, superseded tests, redundant comments, duplicated documentation, obsolete release notes, and artefacts left over from earlier approaches.

### Final review

Before declaring the task complete, verify:

* The implementation matches the requested behaviour.
* The final design is not unnecessarily complicated.
* No accidental public API was introduced.
* Public documentation contains only relevant, intentional, supported behaviour.
* Documentation shows the canonical usage rather than every accepted variation.
* Parser tolerance and defensive edge cases have not been advertised as features.
* Examples use the recommended syntax and conventions.
* Minor features have not received disproportionate documentation.
* Upgrade instructions contain only actions users actually need to take.
* Release notes compare released v2 directly with final v3.
* Intermediate v3 history appears only in the planning document when genuinely useful.
* Code comments meet the strict rules above.
* Existing documentation was edited instead of accumulating contradictory notes.
* Tests cover behaviour without overfitting to internals.
* Commits are atomic and the complete diff contains no abandoned approach.
* The documentation reads naturally and matches the maintainer’s voice.
* Every added sentence earns its place by helping a normal HydePHP user.

When reporting your work, distinguish clearly between user-facing changes and internal implementation changes. Do not inflate internal refactors, parser tolerance, or defensive behaviour into framework features.
