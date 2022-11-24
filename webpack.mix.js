const mix = require("laravel-mix")
const folder = {
    src: "resources/assets/", // source files
    public: "public/", // build files
}

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

// copy all fonts
mix.copyDirectory(folder.src + "fonts", folder.public + "fonts")

// copy all images
mix.copyDirectory(folder.src + "images", folder.public + "images")

mix.sass(
    folder.src + "scss/config/saas/app.scss",
    folder.public + "css"
).options({ processCssUrls: false })
// .minify(folder.public + "css/app.css");;

mix.js("resources/ts/app.ts", folder.public + "js")
    .vue({ version: 3 })
    .webpackConfig({
        module: {
            rules: [
                {
                    test: /\.tsx?$/,
                    loader: "ts-loader",
                    options: { appendTsSuffixTo: [/\.vue$/] },
                    exclude: /node_modules/,
            },
            ],
        },
        resolve: {
            extensions: ["*", ".js", ".jsx", ".vue", ".ts", ".tsx"],
        },
    })
    .alias({
        "@": "resources/ts",
        "@assets": "resources/assets",
    })
    .sourceMaps()
    .webpackConfig(require("./webpack.config"))

if (mix.inProduction()) {
    mix.version()
}

mix.disableNotifications()

/*
 |--------------------------------------------------------------------------
 | Browsersync Reloading
 |--------------------------------------------------------------------------
 |
 | BrowserSync can automatically monitor your files for changes, and inject your changes into the browser without requiring a manual refresh.
 | You may enable support for this by calling the mix.browserSync() method:
 | Make Sure to run `php artisan serve` and `yarn watch` command to run Browser Sync functionality
 | Refer official documentation for more information: https://laravel.com/docs/9.x/mix#browsersync-reloading
 */

mix.browserSync("127.0.0.1:8000")
