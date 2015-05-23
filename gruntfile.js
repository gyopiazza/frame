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
        tasks:  'grunt/',
        hooks:  'hooks/',
        tests:  'tests/',
        docs:   'docs/'
    };


   //////////////////////////////////////////////////////////////


    // Autoload tasks from config.tasks

    var path = require('path');

    require('load-grunt-config')(grunt, {
        // path to task.js files, defaults to grunt dir
        configPath: path.join(process.cwd(), config.tasks),

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
    grunt.registerTask('default', ['sass:dev', 'autoprefixer', 'combine_mq', 'cssmin', 'uglify:main', 'uglify:plugins', 'watch', 'notify:watch']);

    // Compile only
    grunt.registerTask('compile', ['sass:dev', 'autoprefixer', 'combine_mq', 'cssmin', 'uglify:main', 'uglify:plugins', 'notify:watch']);

    // BrowserSync and Watch for live refresh
    grunt.registerTask('live', ['browserSync', 'watch']);

    // Build and create a project package ready for publishing
    // Only compiled css/js files are included
    // Any file or folder starting with an underscore '_' will not be included
    grunt.registerTask('build', ['sass:build', 'autoprefixer', 'combine_mq', 'cssmin', 'uglify:main_build', 'uglify:plugins_build', 'clean:build', 'copy:build', 'imagemin', 'compress', 'notify:build']);

    // Build and create a project package for development
    // All the files are included
    grunt.registerTask('build-dev', ['sass:dev', 'autoprefixer', 'combine_mq', 'cssmin', 'uglify:main', 'uglify:plugins', 'clean:build', 'copy:dev', 'imagemin', 'compress', 'notify:build']);

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
