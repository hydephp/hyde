---
priority: 35
category: "Digging Deeper"
---

# Updating Hyde

## While Hyde is in beta, stuff can change rapidly.
This guide will help you update Hyde to the latest version. It is recommended to back up your source files before updating.

## Updating Hyde/Framework 

Run the following command from your Hyde/Hyde installation:
```bash
composer update hyde/framework
```

Next, follow the post-update instructions for Hyde/Hyde.

## Updating Hyde/Hyde 
When updating an existing installation, first ensure you have a Git backup of your source files to revert the update.

Depending on how you installed Hyde, there are a few different ways to update it.

### Using Git
Make sure you have a remote set up for the repository.
```bash
git remote add upstream https://github.com/hydephp/hyde.git
```

Then pull the latest changes from the remote:
```bash
git pull upstream master
```

After this, you should update your composer dependencies:
```bash
composer update
```

Next, follow the post-update instructions for Hyde/Hyde.

### Manual Update
Since all resource files are in the content directories you can simply copy those files to the new location.

If you have changed any other files, for example in the App directory, you will need to update those files manually as well. But if you have done that you probably know what you are doing. I hope. The same goes if you have created any custom blade components or have modified Hyde ones.

Example CLI workflow, assuming the Hyde/Hyde project is stored as `my-project` in the home directory:
```bash
cd ~
mv my-project my-project-old
composer create-project hyde/hyde my-project

cp -r my-old-project/_pages my-project/content/_pages
cp -r my-old-project/_posts my-project/content/_posts
cp -r my-old-project/_media my-project/content/_media
cp -r my-old-project/_docs my-project/content/_docs
cp -r my-old-project/config my-project/config
```

Next, follow the post-update instructions for Hyde/Hyde. After verifying that everything is working, you can delete the old project directory.

## Post-update instructions
After updating Hyde you should update your config and resource files. This is where things can get a tiny bit dangerous as the files will be overwritten. However, since you should be using Git, you can take care of any merge conflicts that arise.

```bash
php hyde update:configs
php hyde update:assets
```

If you have published any of the Hyde Blade components you will need to re-publish them.

```bash
php hyde publish:views layouts
php hyde publish:views components
```

Next, re-build your site.

```bash
php hyde build
```

And recompile your assets if applicable.

```bash
npm install
npm run dev/prod
```
