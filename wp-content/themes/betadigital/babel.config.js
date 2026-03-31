module.exports = {
  presets: [
    ['@babel/preset-env', { targets: "defaults, not IE 11, since 2020" }],
    '@babel/preset-react'
  ]
};
