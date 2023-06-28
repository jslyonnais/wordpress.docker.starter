// Importing the necessary modules
// defineConfig is used to define the configuration for Vite
// path is a Node.js module for working with file and directory paths
// vite-plugin-static-copy is a Vite plugin to copy static files to the dist directory
// vite-plugin-live-reload is a Vite plugin to reload the page when certain files change
import { defineConfig } from 'vite';
import path from 'path';
import { viteStaticCopy } from 'vite-plugin-static-copy';
import liveReload from 'vite-plugin-live-reload';

// Defining the directories for the theme and the source files
// This makes it easier to refer to these paths later in the configuration
const themes = 'app/themes/custom';
const source = {
  src: path.resolve(__dirname, `${themes}/assets/src`),
  build: path.resolve(__dirname, `${themes}/assets/dist`),
};

// Exporting the configuration object for Vite
// This object defines how Vite should behave
export default defineConfig({
  // Define Vite plugins
  plugins: [
    // Reload the page whenever a PHP file in the theme directory changes
    liveReload(path.resolve(__dirname, `${themes}/**/*.php`)),
    // Copy static files to the dist directory
    viteStaticCopy({
      targets: [
        {
          src: path.join(source.src, '/images/*'),
          dest: path.join(source.build, '/images'),
        },
        {
          src: path.join(source.src, '/favicon/*'),
          dest: path.join(source.build, '/favicon'),
        },
        {
          src: path.join(source.src, '/fonts/*'),
          dest: path.join(source.build, '/fonts'),
        },
      ],
    }),
  ],
  // CSS configuration
  // css: {
  //   preprocessorOptions: {
  //     // Define options for SCSS
  //     scss: {
  //       // Automatically import variables.scss in all SCSS files
  //       additionalData: `@import "${path.join(
  //         source.src,
  //         '/scss/_variables.scss'
  //       )}";`,
  //     },
  //   },
  // },
  // Build configuration
  build: {
    // Enable the generation of a build manifest
    manifest: true,
    minify: true,
    write: true,
    rollupOptions: {
      // Define the entry points for the application
      input: {
        styles: path.join(source.src, '/scss/main.scss'),
        scripts: path.join(source.src, '/js/main.js'),
      },
      // Define the output options for the build
      output: {
        dir: source.build,
        entryFileNames: 'scripts-[hash].js',
        assetFileNames: 'styles-[hash].css',
      },
    },
  },
  // Server configuration
  server: {
    // Define a proxy for the server
    // This is useful when you want to integrate with a backend server
    proxy: {
      '/': 'http://127.0.0.1/',
    },
    // Enable CORS
    cors: true,
    // Ensure that the server uses the exact port defined in the port option
    strictPort: true,
    // Define the port the server should run on
    port: 3000,
    // Define whether the server should use HTTPS or not
    https: false,

    // If you want to serve over HTTPS, follow the instructions in the comments below
    //https: {
    //  key: fs.readFileSync('localhost-key.pem'),
    //  cert: fs.readFileSync('localhost.pem'),
    //},
  },
});
