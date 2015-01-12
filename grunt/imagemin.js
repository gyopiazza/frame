// Image optimization
module.exports = {
    dist: {
        options: {
            optimizationLevel: 7,
            progressive: true,
            interlaced: true
        },
        files: [{
            expand: true,
            cwd: '<%= config.root %><%= config.img %>',
            src: ['**/*.{png,jpg,gif}'],
            dest: '<%= config.build %><%= config.img %>'
        }]
    }
};