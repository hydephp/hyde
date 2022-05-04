// darkmode-test.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test

before(() => {
	// Add files in the _pages directory
	cy.exec('php cypress/support/reset.php')
	cy.writeFile('_pages/about.md', 'about.md')
	cy.exec('php hyde publish:homepage posts -n')
	cy.exec('php hyde build')
})

after(() => {	
	// Remove files in the _pages directory
	cy.exec('php cypress/support/reset.php')
})

describe('Test the dark mode switcher', () => {
	it('Checks that the dark mode switcher is present', () => {
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: true,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		cy.get('[title="Toggle theme"]').should('exist')
	});

	// Assumes dark mode is default
	it('Checks that the theme is switched when triggering the button', () => {
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: true,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		cy.get('[title="Toggle theme"]').click()
		cy.get('html').should('not.have.class', 'dark')

		cy.get('[title="Toggle theme"]').click()
		cy.get('html').should('have.class', 'dark')
	});

	// Check that the selected theme persists when reloading the page
	it('Checks that the theme is persisted when reloading the page', () => {
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: true,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		cy.get('[title="Toggle theme"]').click()
		cy.reload()
		cy.get('html').should('not.have.class', 'dark')
	});

	// Check that the theme is persisted when navigating to another page
	it('Checks that the theme is persisted when navigating to another page', () => {
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: true,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		cy.get('[title="Toggle theme"]').click()
		cy.visit('/_site/about.html')
		cy.get('html').should('not.have.class', 'dark')
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: true,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		cy.get('html').should('not.have.class', 'dark')
	});

	// Check that the selected theme is stored in localstorage
	it('Checks that the theme is stored in localstorage', () => {
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: true,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		expect(localStorage.getItem("color-theme")).to.eq(null);
		cy.get('[title="Toggle theme"]').click().should(() => {
			expect(localStorage.getItem("color-theme")).to.eq('light');
		})
		cy.get('[title="Toggle theme"]').click().should(() => {
			expect(localStorage.getItem("color-theme")).to.eq('dark');
		})
	});

	// Check that dark mode is automatically enabled when user prefers dark mode
	it('Checks that dark mode is automatically enabled when user prefers dark mode', () => {
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: true,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		cy.get('html').should('have.class', 'dark')
	});

	// Check that dark mode is not enabled when user prefers light mode
	it('Checks that dark mode is not enabled when user prefers light mode', () => {
		cy.visit('/_site/index.html', {
			onBeforeLoad: (win) => {
				cy.stub(win.matchMedia = () => ({
					matches: false,
					addListener: () => { },
					removeListener: () => { }
				}))
			}
		})
		cy.get('html').should('not.have.class', 'dark')
	});
});
