<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Maker Manager 4');


// Project repository
set('repository', 'git@github.com:Dallas-Makerspace/makermanager4.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', []);
set('allow_anonymous_stats', false);

// Hosts

host('ec2-18-232-250-239.compute-1.amazonaws.com')
    ->user('deploy')
    ->set('deploy_path', '/srv/www/votingrights.dallasmakerspace.org/app');
    
// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

