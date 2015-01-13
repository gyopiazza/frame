// Rename files and folders
module.exports = {
	disable_hooks: {
        files: [{
            expand: true,
            cwd: '<%= config.root %><%= config.hooks %>',
            src: '*.*',
            dest: '<%= config.root %><%= config.hooks %>',
            rename: function(dest, src) {
                return dest + '_' + src;
            }
        }]
    },
    enable_hooks: {
        files: [{
            expand: true,
            cwd: '<%= config.root %><%= config.hooks %>',
            src: '*.*',
            dest: '<%= config.root %><%= config.hooks %>',
            rename: function(dest, src) {
                if (src.charAt(0) === '_')
                    src = src.slice(1);

                return dest + src;
            }
        }]
    }
};