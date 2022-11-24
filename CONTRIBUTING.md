# Table of Contents

[[_TOC_]]

# Development environment setup

You should install the latest version of Node.js LTS (rommended version is v16 TLS). You should probably use a version
manager tool like [asdf][1]
or [nvm][2]. If you need to use `sudo` when installing packages, your development environment is probably broken.

## Project setup

After cloning this repo, run the following scripts:

```shell
composer install

php artisan migrate

npm install

npm run dev
```

## Run the application

To run the project, start the embedded webserver from the root directory.

- Shell 1

```shell
php artisan serve
```

- Shell 2

```shell
npm run watch
```

By default, this will automatically open a web browser to load the app at
[http://localhost:8080](http://localhost:8080).

# Frameworks/libraries

The following is a list of development frameworks and libraries that are used extensively throughout the project. You
should take some time to get familiarized with them and read through the docs:

* [Vue.js](https://vuejs.org/): Javascript framework for developing web-based UIs.
    * The application currently uses Vue 3.
* [Pinia](https://pinia.vuejs.org//): State management library for Vue.js applications (Pinia is Vuex 5 but it).
* [Firebase](https://firebase.google.com/): For application deployment.
* [Typescript](https://www.typescriptlang.org/): Main language for modules, Vuex stores and Vue components.
    * Adoption of TS was made recently, and thus, not all modules/components have been migrated to TS yet.
    * When developing new features, new components/modules are expected to be written in TS, and existing ones are to be
      migrated to TS if possible.
* [ESLint](https://eslint.org/): Code linting for JS, TS and Vue files.
* [Jest](https://jestjs.io/): Testing framework for Javascript unit tests. (Added later in the late development stage)
    * Testing has been adopted recently, so test coverage of the application is low at the moment.
    * Unit tests should be written for components/modules whenever possible.
* [Cypress](https://www.cypress.io/): Testing framework for E2E/integration tests. (Added later in the late development
  stage)
* [Sentry](https://sentry.io/): Error tracking platform. (Added later in the late development stage)

# Deployment environments

Please refer to the [Deployment Environments](./DEPLOY.adoc#user-content-deployment-environments) section in
the [Deployment Guide](./DEPLOY.adoc).

# Basic guidelines

## Git workflow

The project follows the [Gitflow](https://nvie.com/posts/a-successful-git-branching-model/) branching model:

* `master` contains the code deployed to `production`.
* `develop` contains the code currently in `development`.

In general, no one should push commits directly to `master` nor `develop`. Changes should be made to *feature branches*
and submitted via merge request instead.

### Merge request (MR) guidelines

* With a few exceptions, feature branch names follow this format: `issues/XXX-mr-name`
    * `XXX` is the number of the Gitlab issue assigned to the requested feature or bug report.
    * Examples: `issues/231-video-calls`, `issues/528-fix-dicom-viewer`.
* The following branch name patterns are reserved for deployment purposes and SHOULD NOT be used in feature branches:
    * `/releases/1.0.0`
    * `/releases/1.0.1-hotfix-SOMETHING``
* MRs of feature branches should point to either:
    * `develop` if the changes are rather small.
    * Some parent *feature branch* that points to `develop` if the requested changes are rather big. For example:

      ```
      develop
      -> issues/324-video-calls // Parent feature branch with basic changes
      ---> issues/324-upgrade-webrtc-libs
      ---> issues/324-use-calls-rest-api
      ---> issues/324-video-calls-ui
      ```

* MR descriptions should:
    * Contain
      a [reference/link](https://docs.gitlab.com/ee/user/project/issues/crosslinking_issues.html#from-linked-issues) to
      the original issue.
    * SHOULD NOT contain [issue auto-close patterns][6].
        * Issues should be closed manually by the project manager after QA has finished.
* MR commits SHOULD NOT contain [issue auto-close patterns][6] as well.
* Unless extreme circumstances are involved, all MRs should be assigned for [review](./REVIEW.md) to another project
  member, prior to being merged to `develop`.
* Developers are encouraged to [self-review](./REVIEW.md) their MR before submitting it to a peer.

## File naming conventions

The following are general guidelines for naming files in the project. Note that exceptions can be made for specific file
names required by the frameworks in use.

* Use **snake_case** for:
    * JS/TS modules and Vuex stores (Ex: *audio_recording.ts, xml_parsing.ts*)
    * TS general type definition modules (Ex: *types/utils.ts, types/groups_common.ts*)
* Use **PascalCase** for:
    * Vue components (Ex: *LoginForm.vue, ImageEditor.vue*)
    * Vue mixins (Ex: *ApiValidation.ts, RouteHelpers.ts*)
    * TS single-file type definitions (Ex: *types/GroupMember.ts, types/User.ts*)
* Use **kebab-case** for:
    * CSS/SCSS stylesheets (Ex: *beemata-icons.css, beemata-body-dark.scss*)
    * Fonts, images and other assets (Ex: *beemata-icons.woff, beemata-logo.svg*)
* Use **camelCase** for:
    * Cypress integration tests (Ex: *createCall.spec.ts, chatRoomInput.spec.ts*)
    * TS declaration (.d.ts) files (Ex: *declarationsComponentOptions.d.ts*)
* About tests for components, mixins, modules and stores: (Added only for documentation purpose)
    * Test files are to be placed on the same folder as the corresponding file being tested.
    * Filename should match with the corresponding file, with extension `.jest.spec.ts`:
        * *DateHelpers.ts* -> *DateHelpers.jest.spec.ts*
        * *BasicForm.vue* -> *BasicForm.jest.spec.ts*
        * *deep_freeze.ts* -> *deep_freeze.jest.spec.ts*

## Vue components

Vue components in the application are SFCs (single file components) with more or less the following structure:

```vue
// ExampleComponent.vue

<template>
    // content
</template>

<script lang="ts">
// Typescript code
import {defineComponent} from 'vue'

export default defineComponent({
    // Filename should match the component name (e.g. ExampleComponent.vue)
    name: 'ExampleComponent',
    // Component names should be in PascalCase
    mixins: [ComponentMixin],
    ...
})
</script>

<style lang="scss">
// SCSS class definitions
.example-component {
    // Scope all CSS rules applied to this component within a single CSS class
    // which should be set to the root element of the component's template
    ...
}
</style>
```

### Components and store methods naming

Properties in components and stores, if possible, are subjected to following small rules in naming according to their
actions and purposes.

* For properties that determine whether to show/hide some element --> **__Visible** (eg. **modalVisible**)
* For methods that toggle visibility to be true --> **show___** (eg. **showModal**)
* For methods that toggle visibility to be false --> **hide___** (eg. **hideModal**)
    * If said methods can toggle visibility to be both true and/or false --> **toggleShow___** (eg. **toggleShowModal**)
* For methods in VueX's store that assign boolean values to a state property that determines whether to show/hide some
  element --> **set___Visibility** (eg. **setModalVisibility**)

### CSS conventions for Vue components with several subcomponents

Components can define CSS classes that can be used directly in subcomponents, under the following conditions:

* Changes in the parent component affect the UI of several subcomponents and sub-subcomponents.
    * In most cases, the parent component is so large that it could be considered as a standalone application by itself.
* Affected subcomponents are 100% guaranteed to be used ONLY by the parent component or subcomponents of the parent.
    * It is strongly recommended to place these subcomponents in a folder named after the parent component to make this
      relationship clear.

This is to be used sparingly, and only under certain scenarios like:

* For performance reasons when the amount of affected subcomponent instances is potentially large.
* For dynamically skinning/theming the parent component and subcomponents.

```vue
// ./ParentComponent.vue
<template>
    //- Scoping CSS class MUST be used always
    .parent-component(
    //- Modifier CSS classes are applied to root element ONLY
    :class=`{
    'parent-component--simple-mode': isSimpleMode,
    'parent-component--several-items': items.length > 10
    }`
    )
    ...

</template>

<script lang="ts">
...
export default defineComponent({
    name: 'ParentComponent',
    ...
})
</script>

<style lang="scss">
// Default style for parent component
.parent-component {
    ...
}

// Parent component style when in simple mode
// Naming MUST follow the following format: component-name--modifier-name
.parent-component--simple-mode {
    // Helper classes that can be reused among child components.
    // Naming MUST follow the following format: component-name--modifier-name--helper-name
    .parent-component--simple-mode--hidden {
        display: none;

        ..
    }

    .parent-component--simple-mode--float-right {
        float: right;

        ..
    }

    ...
}

// Parent component style when it has several items
.parent-component--several-items {
    .parent-component--several-items--downscaled {
        transform: scale(0.5);

        ..
    }

    ...
}
</style>
```

```vue
// ./ParentComponent/ChildComponent.vue
<template lang="pug">
//- Scoping CSS class MUST be used always
.child-component
  //- Show username, but hide it in simple mode
  .user-name.parent-component--simple-mode--hidden

  //- Show avatar and downsize it when there's multiple items
  .user-avatar.parent-component--several-items--downscaled

  ...


</template>

<script lang="ts">
...
export default defineComponent({
    name: 'ChildComponent',
    ...
})
</script>

<style lang="scss">
.child-component {
    // Default style for child component
    ...
        // Child component style when parent is in simple mode
    .parent-component--simple-mode & { // Note the & at the end
        ...
    }

    // Child component style when parent has several items
    .parent-component--several-items & {
        ...
    }
}
</style>
```

## Pinia

The application uses Pinia for state management. Code that is to be reused across multiple components or sections of the
application should be considered as candidates for a `store`. Please refer to pinia's official web to learn more on how
to use this package.

# Code Linting

Linting is executed automatically when saving the file. Please check your respective IDE's web on how to properly setup
this feature.

If you need to run the linter manually for all files:

```shell
# Run ESLint
npm run lint
```

Notes:

* Linting tasks are executed automatically by the CI when MRs are submitted.
* Developers are expected to submit MRs that pass all linter checks prior to review.
* MRs that fail to pass these checks will not be merged to `develop`.

# Localization

Localization of the text content found throughout the application is made through this tool
called [Weblate](http://localization.beemata.dev/).

## Adding translation keys

Please refer to the [following guide](#) for information about creating new translation keys.

## Policies regarding translation keys

* Before creating new keys, check if there's already an existing key that has the desired text content.
    * Make sure to check if the content would apply for the situation in question for all languages.
* `CENTRAL_WEB_*` keys are used for content that is expected to be shown on the webclient only.
* `CENTRAL_ANDROID_*` or `CENTRAL_IOS_*` keys should not be used directly.
    * If needed, you should create a `CENTRAL_WEB_*` key instead and duplicate the content.
* Existing keys SHOULD NOT be deleted under any circumstances.
    * `CENTRAL_WEB_*` keys are also subject to this rule.
    * If a `CENTRAL_WEB_*` key is not used anymore it can be unlinked from the CENTRAL app/project in Weblate, but not
      deleted.
* Existing keys SHOULD NOT be changed without asking permission to other dev teams first.
    * `CENTRAL_WEB_*` keys are exempted to this rule.
    * If the existing content has some typos, this should be informed first and not changed directly.

# Package Upgrades

## NPM Package Updates

* List outdated packages:

  ```shell
  npm outdated
  ```

* Audit packages for vulnerabilities:

  ```shell
  npm audit
  ```

* Update package: (May require changes in `package.json`)

  ```shell
  npm update PACKAGE_NAME
  ```

[1]: https://github.com/asdf-vm/asdf

[2]: https://github.com/nvm-sh/nvm

[3]: https://pinia.vuejs.org/introduction.html#comparison-with-vuex
