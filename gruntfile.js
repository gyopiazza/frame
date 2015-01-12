'use strict';
module.exports = function(grunt) {

    //////////////////////////////////////////////////////////////


    // Configuration

    var config = {
        root:   'theme/', // or 'theme-child/'
        build:  'build/',
        css:    'assets/css/',
        sass:   'assets/sass/',
        js:     'assets/js/',
        img:    'assets/img/',
        tests:  'tests/'
    };

    
    //////////////////////////////////////////////////////////////


    var path = require('path');

    require('load-grunt-config')(grunt, {
        // path to task.js files, defaults to grunt dir
        configPath: path.join(process.cwd(), 'grunt'),

        // auto grunt.initConfig
        init: true,

        // data passed into config. Can use with <%= config.element %>
        data: {
            config: config
        },

        // can optionally pass options to load-grunt-tasks.
        // If you set to false, it will disable auto loading tasks.
        loadGruntTasks: {
            pattern: 'grunt-*',
            config: require('./package.json'),
            scope: 'devDependencies'
        },

        //can post process config object before it gets passed to grunt
        // postProcess: function(config) {},

        //allows to manipulate the config object before it gets merged with the data object
        // preMerge: function(config, data) {}
    });
    

    //////////////////////////////////////////////////////////////


    // TASKS


    // Compile and watch
    grunt.registerTask('default', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'watch']);

    // Compile only (useful when adding new js plugins)
    grunt.registerTask('compile', ['sass', 'autoprefixer', 'cssmin', 'uglify']);

    // Build and create a theme package ready for publishing
    grunt.registerTask('build', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'clean', 'copy:dist', 'imagemin', 'compress']);

    // Build and create a theme package for development
    grunt.registerTask('build-dev', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'clean', 'copy:dev', 'imagemin', 'compress']);

    // Run the tests
    grunt.registerTask('test', ['dalek']);


    //////////////////////////////////////////////////////////////

};
