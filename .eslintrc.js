module.exports = {
    globals: {
        route: true, // to fix ziggy route() function eslint error in component script tag
    },
    env: {
        node: true,
        browser: true,
        commonjs: true,
        jquery: true,
        es6: true,
        // "vue/setup-compiler-macros": true, // https://dev.to/imomaliev/til-2021-10-04-fix-script-setup-defineprops-is-not-defined-38ic
    },
    extends: ["eslint:recommended", "plugin:vue/vue3-recommended", "prettier"],
    ignorePatterns: [
        "resources/ts/@types/**",
        "resources/ts/Pages/plugins/**", // TODO: Remove
    ],
    rules: {
        semi: ["error", "never"],
        "vue/multi-word-component-names": "off", // do not use multi-word component names
    },
    plugins: ["vue"],
    parser: "vue-eslint-parser", // to fix defineProps() eslint error
    parserOptions: {
        ecmaVersion: 2018,
        sourceType: "module",
        parser: "@typescript-eslint/parser",
    },
    "overrides": [
        {
            files: ["*.vue", "*.ts"],
            rules: {
                "no-undef": "off",
            }
        }
    ]
}
