// Javascript linting with jshint
module.exports = {
    options: {
        jshintrc: '.jshintrc',
        "force": true
    },
    all: [
        'gruntfile.js',
        '<%= config.root %><%= config.js %>source/**/*.js'
    ]
};