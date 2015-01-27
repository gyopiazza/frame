// Testing suite
module.exports = {
    options: {
        // browser: ['phantomjs', 'chrome'],
        browser: ['chrome'],
        reporter: ['console', 'html'],
        dalekfile: false,
        advanced: {
            reporter: ['console', 'html'],
            'html-reporter': {
               dest: 'reports'
            }
        }
    },

    all: {
      src: ['<%= config.tests %>**/*.js']
    }
};
