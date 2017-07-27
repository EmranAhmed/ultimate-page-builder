# Ultimate Page Builder

An Incredibly easiest and highly customizable drag and drop page builder helps create professional websites without writing a line of code.

## Development

### Using NPM

#### Dev mode
- `npm i`
- `npm run dev`
- `define( 'SCRIPT_DEBUG', TRUE );` on `wp-config.php` file on development mode.

#### Production move

- `npm run build`

## Using Yarn

#### Dev mode
- `yarn install`
- `yarn dev`
- Check [Yarn Usage](https://yarnpkg.com/en/docs/usage)
- Check [Yarn Documentation](https://yarnpkg.com/en/docs/cli/)

#### Production
- `yarn build`

### Bundle

- Remove CSS / JS from `assets/css` and `assets/js`
- `yarn bundle` or `npm run bundle`

### Package

- Remove CSS / JS from `assets/css` and `assets/js`
- `yarn package` or `npm run package`

### Add / Update package

- `yarn add [package] --dev` or `yarn add [package]`
- `yarn upgrade` - updates all dependencies to their latest version based on the version range specified in the `package.json` file
