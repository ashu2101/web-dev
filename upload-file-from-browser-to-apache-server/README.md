## Key Notes before implemention:
1. Below configurations are tried and tested on Linux instance and Windows instance. Command on Windows may differ than belwo.
2. All uploaded files are stored in ```/tmp``` folder as this folder has all allow read-write-execute access for all users and groups. For windows you can configure any location you wish to by changing below code.
```php
 $dir_location = '/tmp/'.$_POST['location'].'/';
```
4. We have created sub folders in ```/tmp``` with name extensions and scripts  based on our product requirement. If you have any other folder requirment perform below changes in html code and php code resp.
ex: Lets consider you want to upload files to ```/opt/kits/app1``` dirictory, you need to do below changes.
```sh
cd /opt/kits
ln -s /tmp/app1 app1 #creating simlink reffering to /tmp/app1 folder.
```
```html
<option value="app1">APP1 Folder</option>  <!--value should match subfolder name in /tmp-->
```


## Step 1: Install apache and php on RHEL server

- Install the httpd, php and php-fpm module:
```sh
yum install httpd php php-fpm -y
```

- Start the httpd and php-fpm service:
```sh
systemctl restart httpd php-fpm
```

- Enable both services to start at boot time:
```sh
systemctl enable php-fpm httpd
```


## Step 2: To try if apache and php are configred try below command

- To obtain information about your PHP settings, create the ```temp.php``` file with the following content in the ```/var/www/html/``` directory:
```sh
echo '<?php phpinfo(); ?>' > /var/www/html/temp.php
```

- To run the ```temp.php``` file, point the browser to:
```html
http://<hostname>/temp.php
```

## Step 3: Disable PrivateTmp configurations in  /usr/lib/systemd/system/httpd.service
```sh
vim /usr/lib/systemd/system/httpd.service
```

Set ```PrivateTmp=true ``` to ```PrivateTmp=false ``` 

```sh
systemctl restart httpd
```


## Step 4:  Create simlink for extensions folder and scripts folder in /opt/polarion/polarion/extensions and /opt/polarion/scripts
```sh
cd /opt/polarion/polarion/extensions
ln -s /tmp/extensions new_extensions
cd /opt/polarion/scripts
ln -s /tmp/scripts new_scripts
```

## Step 5: Create a upload.php file and copy the php code present in repo.
```sh
cd /var/www/html
touch upload.php
chown apache:apache upload.php
chmod +x upload.php
#Paste the upload.php file content from repo to above file in server
```

## Step 6: Access your uploader site ```http://<hostname>/upload.php```



## Additional Configurations:
If you wan to upload larger files on to server, you need to do below configuration changes in ```/etc/httpd/conf.d/php.conf```. This file is created automatically when you install php-fpm binaries.
```sh
#Additional configurations for uploadin large files
# Max time for transaciton before it terminsates
php_value max_execution_time 3600 
# Max file size of file that can be uploaded
php_value upload_max_filesize 500M  
# Max file size the upload can handleMax size
php_value post_max_size 500M        
php_value memory_limit -1           
php_value max_input_time -1
LimitRequestBody 0
```

### Add security to your page:
Add belowo configurations to ```php.conf``` file locate in ```/etc/httpd/conf.d``` 
We need to create a /opt/passwd file to store use and password credentials. Use htpasswd command to create new password.
```sh
<Location /upload.php>

# No anonymous access, always require authenticated users
Require valid-user

# How to authenticate a user.
AuthType Basic
AuthName "File Uploader"
AuthUserFile "/opt/passwd"
</Location>
```


#### Note:
1- Not able to upload file to server: Check the apache logs in /var/log/html/error_log for error messages. You need to changes folder permissions to accomplish this. Preffered is to use /tmp dir as storage location.

2- If want to change the destincation folder location, change the the name of simlinks created in step 3 with your directory location. Change options value in the update.php
ex: 
```sh
ln -s /tmp/sub_dir1 /opt/
ln -s /opt/kits kits
```
```html
<option value="opt">OPT</option>
<option value="kits">Kits</option>
```
3. You need to replace hostname with your actual hostname in  http://hostname/upload.php


#### Ref Links: 
- [Apache and PHP configuration for RHEL](https://access.redhat.com/documentation/en-us/red_hat_enterprise_linux/8/html/configuring_basic_system_settings/using-the-php-scripting-language_configuring-basic-system-settings)
- [Configurations to upload large files](https://www.bluelinemedia.co.uk/blog/entry/web-design/blog/upload-large-files)
