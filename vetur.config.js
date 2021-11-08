// vetur.config.js
/** @type {import('vls').VeturConfig} */
module.exports = {
    // **optional** default: `{}`
    // override vscode settings part
    // Notice: It only affects the settings used by Vetur.
    settings: {
        "vetur.useWorkspaceDependencies": true,
        "vetur.experimental.templateInterpolationService": true,
    },
    projects: [
        {
            root: "./resources/app",
            package: "./package.json",
            tsconfig: "./tsconfig.json",
        },
    ],
};
