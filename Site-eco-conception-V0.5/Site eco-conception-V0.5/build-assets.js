const esbuild = require("esbuild");
const path = require("node:path");

const assets = [
    ["style.css", "style.min.css"],
    [path.join("viewer", "viewer.css"), path.join("viewer", "viewer.min.css")],
    [path.join("js", "loadpage.js"), path.join("js", "loadpage.min.js")],
    [path.join("viewer", "scriptViewer.js"), path.join("viewer", "scriptViewer.min.js")],
    [path.join("connexion", "style.css"), path.join("assets", "connexion.min.css")],
    [path.join("connexion", "js", "functions.js"), path.join("assets", "connexion.min.js")],
];

const watch = process.argv.includes("--watch");

async function buildAsset([source, output]) {
    await require("node:fs/promises").mkdir(path.dirname(output), { recursive: true });

    const options = {
        entryPoints: [source],
        outfile: output,
        bundle: false,
        minify: true,
        legalComments: "none",
        logLevel: "info",
    };

    if (watch) {
        const context = await esbuild.context(options);
        await context.watch();
        return;
    }

    await esbuild.build(options);
}

Promise.all(assets.map(buildAsset)).catch((error) => {
    console.error(error);
    process.exitCode = 1;
});
