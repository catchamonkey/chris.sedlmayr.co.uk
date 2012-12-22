set :application,               "chris.sedlmayr"
set :domain,                    "149.5.47.52"
set :deploy_to,                 "/home/sites/chris.sedlmayr.co.uk"
set :app_path,                  "app"
set :user,                      "chris.sedlmayr"
set :server,                    "149.5.47.52"

set :repository,                "git@github.com:catchamonkey/chris.sedlmayr.co.uk.git"
set :scm,                       :git

set :model_manager,             "doctrine"

role :web,                      domain                         # Your HTTP server, Apache/etc
role :app,                      domain                         # This may be the same as your `Web` server
role :db,                       domain, :primary => true       # This is where Symfony2 migrations will run

set  :keep_releases,            3

# shared between releases
set  :shared_children,          [log_path, web_path + "/uploads"]
set  :shared_files,             ["app/config/parameters.yml"]

# composer config
set  :use_composer,             true
set  :composer_options,         "--verbose -o --prefer-dist"

set  :use_sudo,                 false

default_run_options[:pty] =     true
ssh_options[:forward_agent] =   true


# asset management
set  :assets_install,           true
set  :update_assets_version,    true
set  :cache_warmup,             true
set  :dump_assetic_assets,      true

set  :webserver_user,           "apache"
set  :writable_dirs,            [log_path, cache_path]
# use setfacl to manage permissions of these dirs
set  :permission_method,        :acl

# Execute set permissions
set  :use_set_permissions,      true
before "deploy:restart",        "deploy:set_permissions"

before "symfony:assetic:dump",  "symfony:cache:clear"
# clean up old releases
after "deploy",                 "deploy:cleanup"