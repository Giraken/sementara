const path = require("path")

module.exports = {
    resolve: {
        alias: {
            "@": path.resolve("resources/ts/"),
            "@assets": path.resolve("resources/assets/"),
        },
    },
}
