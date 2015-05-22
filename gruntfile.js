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
        hooks:  'hooks/',
        tests:  'tests/',
        docs:   'docs/'
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
    grunt.registerTask('build', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'clean:build', 'copy:dist', 'imagemin', 'compress']);

    // Build and create a theme package for development
    grunt.registerTask('build-dev', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'clean:build', 'copy:dev', 'imagemin', 'compress']);

    // Enable all the hooks
    grunt.registerTask('enable_hooks', ['rename:enable_hooks']);

    // Disable all the hooks
    grunt.registerTask('disable_hooks', ['rename:disable_hooks']);

    // Generate documentation from source
    grunt.registerTask('docs', ['clean:docs', 'phpdocumentor']);


    // Run the tests
    // grunt.registerTask('test', ['dalek']);

    // grunt.registerTask('test', 'Run the tests', function(arg1) {

    //   if (arguments.length === 0) {
    //     // grunt.log.writeln(this.name + ", no args");
    //     grunt.task.run(['dalek']);
    //   } else {
    //     // grunt.log.writeln(this.name + ", " + arg1 + " | " + arg2);
    //     grunt.task.run('dalek:'+arg1);
    //   }

    //   // grunt.log.writeln('The task was OK!');
    // });


    //////////////////////////////////////////////////////////////

};
