import { defineConfig } from "vite";
import usePHP from "vite-plugin-php";
import tailwindcss from "@tailwindcss/vite";
import { viteStaticCopy } from "vite-plugin-static-copy";
import { existsSync } from "node:fs";
import { fileURLToPath } from "node:url";

export default defineConfig(({ command }) => {
    return {
        plugins: [
            usePHP({
                entry: ["index.php", "pages/**/*.php", "components/**/*.php"],
                rewriteUrl(requestUrl) {
                    const filePath = fileURLToPath(
                        new URL("." + requestUrl.pathname, import.meta.url),
                    );
                    const publicFilePath = fileURLToPath(
                        new URL(
                            "./public" + requestUrl.pathname,
                            import.meta.url,
                        ),
                    );

                    if (
                        !requestUrl.pathname.includes(".php") &&
                        (existsSync(filePath) || existsSync(publicFilePath))
                    ) {
                        return undefined;
                    }

                    requestUrl.pathname = "index.php";

                    return requestUrl;
                },
            }),
            viteStaticCopy({
                targets: [
                    { src: "public", dest: "" },
                    { src: "system", dest: "" },
                    { src: "vendor", dest: "" },
                ],
                silent: false,
            }),
            tailwindcss(),
        ],
        resolve: {
            alias: {
                "~/": fileURLToPath(new URL("./src/", import.meta.url)),
            },
        },
        publicDir: command === "build" ? "raw" : "public",
        server: {
            port: 8000,
        },
        build: {
            assetsDir: "public",
            emptyOutDir: true,
        },
    };
});
