module.exports = {
  entry: {
    app: ['./resources/css/app.scss', './resources/js/app.js']
  },
  port: 3003,
  html: false,
  assets_url: '/',  // Urls dans le fichier final
  assets_path: './dist/', // ou build ?
  refresh: ['./app/**/*'] // Permet de forcer le rafraichissement du navigateur lors de la modification de ces fichiers
}
