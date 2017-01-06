# Ultimate Page Builder

## Using NPM

### Development
- `npm i`
- `npm run dev`
- `define( 'SCRIPT_DEBUG', TRUE );` on `wp-config.php` file on development mode.

### Production

- `npm run build`

## Using Yarn

### Development
- `yarn install`
- `yarn run dev`
- Check [Yarn Usage](https://yarnpkg.com/en/docs/usage)
- Check [Yarn Documentation](https://yarnpkg.com/en/docs/cli/)

### Build
- `yarn run build`

### Bundle

- Remove CSS / JS from `assets/css` and `assets/js`
- `yarn run bundle`

### Add package

- `yarn add [package] --dev` or `yarn add [package]`
- `yarn upgrade` - updates all dependencies to their latest version based on the version range specified in the `package.json` file
