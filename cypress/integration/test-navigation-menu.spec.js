// test-navigation-menu.spec.js created with Cypress
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

it('tests the navigation menu', () => {
	cy.visit('_site/index.html')

	cy.get('#main-navigation').should('be.visible')
  
	cy.get('#main-navigation-links').should('be.visible')
	cy.get('#main-navigation-links').find('a').should('have.length', 2)

	// Test the first button is home and is active
	cy.get('#main-navigation-links').find('a').eq(0).should('have.attr', 'href', 'index.html')
	cy.get('#main-navigation-links').find('a').eq(0).should('have.attr', 'aria-current')

	// Test that clicking a link takes you to the correct page
	cy.get('#main-navigation-links').find('a').eq(1).click()
	cy.url().should('include', 'about.html')
})

it('tests the mobile navigation menu', () => {
	cy.viewport('iphone-6')
	cy.visit('_site/index.html')

	cy.get('#main-navigation-links').should('not.be.visible')

	cy.get('#navigation-toggle-button').should('be.visible')
	cy.get('#navigation-toggle-button').click()

	cy.get('#main-navigation-links').should('be.visible')
	cy.get('#navigation-toggle-button').click()
	cy.get('#main-navigation-links').should('not.be.visible')
})