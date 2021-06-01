# craft-query-builder-field

Based on https://nystudio107.com/blog/a-vite-buildchain-for-craft-cms-plugins

### Configuration
Assets in this plugin are designed to be available via Craft cpresources
#### Vite
`/buildchain/vite.config.js`
ViteRestart is configured to watch files, but currently is only picking up changes to the configuration file itself (vite.config.js)

Builds required a `docker-compose run vite npm run build` in a separate terminal window currently. We would like changes to be picked up automatically.
#### Sources
TS and Vue files are in /builchain/src/, which is also symlinked to /src/web/assets/


### Testing
Currently, the 'Settings' component has errors, but will still render on the page. To test it:
1. create a new Field in the CMS
2. change the field type from 'Plain Text' -> QueryBuiilder
3. the vue app will load and spit out console messages
