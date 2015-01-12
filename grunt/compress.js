// Compress the theme
module.exports = {
    dist: {
        options: {
          archive: '<%= config.build %><%= package.name %>.zip'
        },
        files: [
          {expand: true, cwd: '<%= config.build %><%= package.name %>/', src: ['**'], dest: './<%= package.name %>'}
        ]
    }
};