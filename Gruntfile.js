module.exports = function(grunt) {
  grunt.initConfig({

	pkg: grunt.file.readJSON('package.json'),
	
	
	rsync: {
		
		respaldo:{
			options:{
				src: "../07/",
				dest:'/Users/fcarrizalest/Desktop/respaldos/phemer/<%= grunt.template.today("dd-mm-yyyy") %>',
				recursive: true,
				exclude: [ "composer.phar", "vendor", "package.json", "node_modules" , "Gruntfile.js"]
			}
		}
	  },
	shell: {
		options: {
			stderr: false
		},
		
		unitTest:{
			command: 'php ./test/bootstrap.php'
		}
	  },
	watch: {
		
	  
		phpWatch: {
		  files: ['public/**/*.php','src/**/*.php', 'test/**/*.php', 'public/js/**/*.js'],
		  tasks: [  'shell:unitTest' ] ,
		  options: {
			livereload: false,
			reload: true,
			interrupt: true,
			livereloadOnError:false,
			dateFormat: function(time) {
      					grunt.log.writeln('The watch finished in ' + time + 'ms at' + (new Date()).toString());
      					grunt.log.writeln('Waiting for more changes...');
    		}
		  }
		}
	}
	
  });

  grunt.loadNpmTasks('grunt-contrib-watch');
  grunt.loadNpmTasks('grunt-rsync');
  grunt.loadNpmTasks('grunt-shell');
  
  grunt.registerTask('ver', [ 'watch:phpWatch']);
 
  grunt.registerTask('default', [ 'watch:phpWatch' ]);
};