---
name: Release (team only)
about: Describes default checklist for the plugin's release process.
title: Release PublishPress Future v[VERSION]
labels: release
assignees: ''

---

To release the Free plugin please make sure to check all the checkboxes below.

### Pre-release Checklist

- [ ] Create the release branch as `release-<version>` based on the development branch.
- [ ] Make sure to directly merge or use Pull Requests to merge hotfixes or features branches into the release branch.
- [ ] Enter the `dev-workspace` folder and run the command `/run` to enter to the continer. The next commands should run there. 
- [ ] Run `$ composer update --dry-run` and check if there is any relevant update. Check if you need to lock the current version for any dependency. No dev requirement should be added to the git repository. If any update is needed, run `$ composer update` and commit the changes.
- [ ] Build JS files to production running `$ npm run build-js` and commit.
- [ ] Run WP VIP scan to make sure no warnings or errors > 5 exists: `$ vendor/bin/phpcs`.
- [ ] Update the changelog - make sure all the changes are there with a user-friendly description and that the release date is correct, commit.
- [ ] Update the version number to the next stable version in the main plugin file and `readme.txt`. Commit the changes to the release branch.
- [ ] Build the zip package, running `$ npm run build`. It should create a package in the `./dist` dir.
- [ ] Send the new package to the team for testing.

### Release Checklist

- [ ] Create a Pull Request and merge the release branch it into the `master` branch.
- [ ] Merge the `master` branch into the `development` branch.
- [ ] Create the GitHub release (make sure it is based on the `master` branch and correct tag). This will trigger a Github action for automatic deployment on the WordPress SVN repo.

### Post-release Checklist

- [ ] Follow the action's result on the [repository actions page](https://github.com/publishpress/publishpress-future/actions).
- [ ] Go to the [WordPress.org plugin page](https://wordpress.org/plugins/post-expirator/) double check the information confirming the release finished successfully.
- [ ] Make a final test updating the plugin in a staging site.
