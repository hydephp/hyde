before(() => {
	cy.exec('php ../../hyde publish:homepage posts -n')
})
  
describe('tests blogging module', () => {
  it('homepage can be changed to blog post feed', () => {
    cy.visit('index.html')
    cy.contains('Latest Posts')
  })

  it('blog posts can be scaffolded and shows up in feed', () => {
	  cy.exec('php ../../hyde make:post -n --force')
    cy.visit('index.html')
	  cy.get('.text-2xl').should('contain', 'My New Post')
  })

  it('blog posts can be clicked to lead to the post', () => {
    cy.visit('index.html')
    cy.get('.text-2xl').click()
    cy.url().should('include', '/posts/my-new-post.html')
  })
})