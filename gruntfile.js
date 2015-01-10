'use strict';
module.exports = function(grunt) {

    // Configuration
    var config = {
        css: 'theme/assets/css/',
        sass: 'theme/assets/sass/',
        js: 'theme/assets/js/',
        tests: 'theme/tests/'
    };

    // Load all grunt tasks matching the `grunt-*` pattern
    require('load-grunt-tasks')(grunt);

    grunt.initConfig({

        // Allow to use variables inside strings (for object keys)
        config: config,

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
                    '<%= config.css %>main.css': config.sass+'main.scss',
                    '<%= config.css %>editor-style.css': config.sass+'editor-style.scss'
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
                src: config.css+'*.css',
                dest: config.css
            },
        },

        // CSS minify
        cssmin: {
            options: {
                keepSpecialComments: 1
            },
            minify: {
                expand: true,
                cwd: config.css,
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
                config.js+'source/**/*.js'
            ]
        },

        // uglify to concat, minify, and make source maps
        uglify: {
            plugins: {
                options: {
                    sourceMap: config.js+'plugins.js.map',
                    sourceMappingURL: 'plugins.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    '<%= config.js %>plugins.min.js': [
                        config.js+'source/plugins.js', // Remove?
                        config.js+'vendor/fastclick.js'
                    ]
                }
            },
            main: {
                options: {
                    sourceMap: config.js+'main.js.map',
                    sourceMappingURL: 'main.js.map',
                    sourceMapPrefix: 2
                },
                files: {
                    '<%= config.js %>main.min.js': [
                        config.js+'source/main.js'
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
                    cwd: config.img,
                    src: ['**/*.{png,jpg,gif}'],
                    dest: config.img
                }]
            }
        },

        // Launch browserSync
        browserSync: {
            dev: {
                bsFiles: {
                    src : ['main.css', config.js+'*.js', config.img+'**/*.{png,jpg,jpeg,gif,webp,svg}']
                },
                options: {
                    proxy: "localhost",
                    // host: "127.0.0.1",
                    watchTask: true
                }
            }
        },

        // Testing suite
        dalek: {
            options: {
                browser: ['phantomjs', 'chrome'],
                reporter: ['console', 'html'],
                dalekfile: false,
                advanced: {
                    reporter: ['console', 'html'],
                    'html-reporter': {
                       dest: 'reports'
                    }
                }
            },

            dist: {
              src: [config.tests+'example-test.js']
            }
        }

    });
    

    //////////////////////////////////////////////////////////////


    // Register tasks
    grunt.registerTask('default', ['sass', 'autoprefixer', 'cssmin', 'uglify', 'watch']);


    //////////////////////////////////////////////////////////////

};
