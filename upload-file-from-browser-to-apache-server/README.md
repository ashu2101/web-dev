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

- To obtain information about your PHP settings, create the index.php file with the following content in the /var/www/html/ directory:
```sh
echo '<?php phpinfo(); ?>' > /var/www/html/temp.php
```

- To run the temp.php file, point the browser to:
```html
http://<hostname>/temp.php
```

## Step 3: Disable PrivateTmp configurations in  ```/usr/lib/systemd/system/httpd.service``` 
```sh
vim /usr/lib/systemd/system/httpd.service
```
Set ```PrivateTmp=true```` to ```PrivateTmp=false```` 
```sh
systemctl restart httpd
```


## Step 4:  Create simlink for extensions folder and scripts folder in ```/opt/polarion/polarion/extensions``` and ```/opt/polarion/scripts```
```sh
cd /opt/polarion/polarion/extensions
ln -s /tmp/extensions new_extensions
cd /opt/polarion/scripts
ln -s /opt/polarion/scripts/ new_scripts
```

## Step 5: Create a ```upload.php``` file and copy the php code present in repo.
```sh
cd /var/www/html
touch upload.php
#Paste the upload.php file content from repo to above file in server
```

## Step 6: Make simlinks in you desired folders pointing to /tmp/extensions and /tmp/scripts as needed.
```sh
cd /opt/polarion/polarion/extensions/
ln -s 
```

## Step 7: Access the http://<hostname>/upload.php


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



#### Ref Links: 
- [Apache and PHP configuration for RHEL](https://access.redhat.com/documentation/en-us/red_hat_enterprise_linux/8/html/configuring_basic_system_settings/using-the-php-scripting-language_configuring-basic-system-settings)
