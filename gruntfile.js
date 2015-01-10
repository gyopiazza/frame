'use strict';
module.exports = function(grunt) {

    // Configuration
    var config = {
        css: 'theme/assets/css/',
        sass: 'theme/assets/sass/',
        js: 'theme/assets/js/'
    };

    // Load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Watch for changes
        watch: {
            sass: {
                files: [config.sass+'**/*.{scss,sass}', '!assets/styles/vendor/'],
                tasks: ['sass', 'autoprefixer', 'cssmin']
            },
            js: {
                files: '<%= jshint.all %>',
                tasks: ['jshint', 'uglify']
            }
            // images: {
            //     files: ['assets/images/**/*.{png,jpg,gif}'],
            //     tasks: ['imagemin']
            // }
        },

        // Sass
        sass: {
            dist: {
                options: {
                    style: 'expanded',
                },
                files: {
                    config.css+'main.css': config.sass+'main.scss',
                    config.css+'editor-style.css': config.sass+'editor-style.scss'
                }
            }
        },

        // Autoprefixer
        autoprefixer: {
            options: {
                browsers: ['last 2 versions', 'ie 9', 'ios 6', 'android 4'],
                map: true
            },
            files: {
                expand: true,
                flatten: true,
                src: 'assets/styles/build/*.css',
                dest: 'assets/styles/build'
            },
        },

        // CSS minify
        cssmin: {
            options: {
                keepSpecialComments: 1
            },
            minify: {
                expand: true,
                cwd: 'assets/styles/build',
                src: ['*.css', '!*.min.css'],
                ext: '.css'
            }
        },

        // Javascript linting with jshint
        jshint: {
            options: {
                jshintrc: '.jshintrc',
                "force": true
            },
            all: [
                'Gruntfile.js',
                'assets/js/source/**/*.js'
            ]
        },

        // uglify to concat, minify, and make source maps
        uglify: {
            plugins: {
                options: {
                    sourceMap: 'assets/js/plugins.js.map',
                    sourceMappingURL: 'plugins.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    'assets/js/plugins.min.js': [
                        'assets/js/source/plugins.js',
                        'assets/js/vendor/fastclick.js'
                    ]
                }
            },
            main: {
                options: {
                    sourceMap: 'assets/js/main.js.map',
                    sourceMappingURL: 'main.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    'assets/js/main.min.js': [
                        'assets/js/source/main.js'
                    ]
                }
            }
        },

        // Image optimization
        imagemin: {
            dist: {
                options: {
                    optimizationLevel: 7,
                    progressive: true,
                    interlaced: true
                },
                files: [{
                    expand: true,
                    cwd: 'assets/images/',
                    src: ['**/*.{png,jpg,gif}'],
                    dest: 'assets/images/'
                }]
            }
        },

        // Launch browserSync
        browserSync: {
            dev: {
                bsFiles: {
                    src : ['main.css', 'assets/js/*.js', 'assets/images/**/*.{png,jpg,jpeg,gif,webp,svg}']
                },
                options: {
                    proxy: "localhost",
                    // host: "127.0.0.1",
                    watchTask: true
                }
            }
        },

    });
    

    //////////////////////////////////////////////////////////////


    // Register tasks
    grunt.registerTask('default', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'watch']);


    //////////////////////////////////////////////////////////////

};
