---
priority: 25
label: "Compile & Deploy"
category: "Creating Content"
---

# Compile and Deploy your site

## Running the build command

### Compile the entire site to static HTML
Now that you have some amazing content, you'll want to compile your site into static HTML.

**This is as easy as executing the `build` command:**
```bash
php hyde build
```

### Other ways to compile the site

**You can also compile a single file:**
```bash
php hyde rebuild <filepath>
```

**And, you can even start a development server to compile your site on the fly:**
```bash
php hyde serve
```

### Further reading

#### Learn more about these commands in the [console commands](console-commands) documentation:

- [Build command](console-commands#build-the-static-site)
- [Rebuild command](console-commands#build-a-single-file)
- [Serve command](console-commands#start-the-realtime-compiler)


#### Key Concept: Autodiscovery
When building the site, Hyde will your source directories for files and compile them into static HTML using the appropriate layout depending on what kind of page it is. You don't have to worry about routing as Hyde takes care of that, including creating navigation menus!

---

## Deploying your site

One of the things that make static sites so enjoyable to work with is how easy it is to deploy them to the web.
This list is not exhaustive, but gives you a general idea of the most common ways to deploy your site.
If you have ideas to add to the documentation, please send a pull request!

### General deployment

In essence, all you need to do is copy the contents of the `_site` directory to a web server and you're done.

Once the site is compiled there is nothing to configure or worry about.

### FTP and File Managers

If you have a conventional web host, you can use FTP/SFTP/FTPS to upload your site to the web server.
Some web hosting services also have web based file managers.

To deploy your site using any of these methods, all you need to do is upload the entire contents
of your `_site` directory to the web server, usually in the `public_html`, `htdocs`, or `www` directory.

### GitHub Pages - Manually

GitHub Pages is a free service that allows you to host your static site on the web.

In general, push the entire contents of your `_site` directory to the `gh-pages` branch of your repository,
or the `docs/` directory on your main branch, depending on how you set it up.

Please see the [GitHub Pages documentation](https://help.github.com/pages/getting-started-with-github-pages/) for more information.

### GitHub Pages - CI/CD

Hyde works amazing with GitHub Pages and GitHub Actions and the entire build and deploy process can be automated.

HydePHP.com is hosted on GitHub Pages, and the site is compiled in a GitHub Action workflow that compiles and 
deploys the site automatically when the source is updated. This is done in the [DocsCI repository](https://github.com/hydephp/DocsCI).

You can take a look at the workflow HydePHP.com uses to create your own workflow.
See the [DocsCI build.yml on GitHub](https://github.com/hydephp/DocsCI/blob/master/.github/workflows/build.yml)
