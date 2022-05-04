// documentation-sidebar-test.spec.js created with Cypress
//
// Start writing your Cypress tests below!
// If you're unfamiliar with how Cypress works,
// check out the link below and learn how to write your first test:
// https://on.cypress.io/writing-first-test

before(() => {
	// Add files in the _pages directory
	cy.exec('php cypress/support/reset.php')
	cy.writeFile('_docs/index.md', 'index.md')
	cy.writeFile('_docs/foo.md', 'foo.md')
	cy.writeFile('_docs/bar.md', 'bar.md')
	cy.exec('php hyde publish:homepage posts -n')
	cy.exec('php hyde build')
})

after(() => {	
	// Remove files in the _pages directory
	cy.exec('php cypress/support/reset.php')
})

// Test index page contains docs item in navigation menu
it('tests the navigation menu contains docs link', () => {
	cy.visit('_site/index.html')

	// Test that clicking a link takes you to the correct page
	cy.get('#main-navigation-links').find('a').eq(1).click()
	cy.url().should('include', 'docs/index.html')
})

// Test the documentation page sidebar
it('tests the documentation page sidebar', () => {
	cy.visit('_site/docs/index.html')

	
	cy.get('#sidebar-navigation').should('be.visible')
	cy.get('#sidebar-navigation').find('a').should('have.length', 2)

	// Test that clicking a link takes you to the correct page
	cy.get('#sidebar-navigation').find('a').eq(0).click()
	cy.url().should('include', 'docs/foo.html')
	cy.get('#sidebar-navigation').find('a').eq(0).should('have.attr', 'href', 'foo.html')
	cy.get('#sidebar-navigation').find('a').eq(0).should('have.attr', 'aria-current')

	// Test that clicking the sidebar header takes you to the docs index page
	cy.get('#documentation-sidebar a').first().should('be.visible')
	cy.get('#documentation-sidebar a').first().should('contain', 'HydePHP Docs')
	cy.get('#documentation-sidebar a').first().click()
	cy.url().should('include', 'docs/index.html')
	cy.get('#sidebar-navigation').find('a').eq(0).should('not.have.attr', 'aria-current')
});

// Test the documentation page sidebar on a mobile device
it('tests the documentation page sidebar on a mobile device', () => {
	cy.viewport('iphone-6')
	cy.visit('_site/docs/index.html')

	cy.get('#sidebar-navigation').should('not.be.visible')

	cy.get('#sidebar-toggle-button').should('be.visible')
	cy.get('#sidebar-toggle-button').click()
	cy.get('#sidebar-toggle-button').click()

	cy.get('#sidebar-navigation').should('be.visible')
	cy.get('#sidebar-toggle-button').click()
	cy.get('#sidebar-navigation').should('not.be.visible')
})