// System notifications
module.exports = {
    build: {
      options: {
        expand: true,
        title: 'Project built', // optional
        message: 'The project has been built in <%= config.build %>' //required
      }
    },
    watch: {
      options: {
        expand: true,
        title: 'CSS compiled', // optional
        message: 'The CSS files have been compiled' //required
      }
    },
    main_js: {
      options: {
        expand: true,
        title: 'Main JS compiled', // optional
        message: 'The main Javascript file has been compiled' //required
      }
    },
    plugins_js: {
      options: {
        expand: true,
        title: 'JS plugins compiled', // optional
        message: 'The Javascript plugins have been compiled' //required
      }
    }
};
