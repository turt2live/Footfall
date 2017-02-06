
WorkingDir=~/openFrameworks/apps/myApps/projectFolder/bin/data/

cd $WorkingDir

#Function to get JSON Data
get_json_config() {
eval $1=`jq $2 config.json`
}

#Function update config
set_json_config() {
jq $1=\"$2\" config.json > temp.config.json
mv config.json config.json.old
mv temp.config.json config.json
rm config.json.old
}

#Get Zone Name
get_json_config 'zonename' '.Footfall.PostDataSettings.zonename'

#Prompt for Zone Name
zone=$(whiptail --title "Expo Configuration Wizard" --inputbox "Please set a zone name." 10 60 $zonename 3>&1 1>&2 2>&3)

#Insert Zone Name
set_json_config '.Footfall.PostDataSettings.zonename' $zone

#Set LocationID
get_json_config 'locationname' '.Footfall.PostDataSettings.location'

#Prompt for LocationID
location=$(whiptail --title "Expo Configuration Wizard" --inputbox "Please set a LocationID." 10 60 $locationname 3>&1 1>&2 2>&3)

#Insert LocationID
set_json_config '.Footfall.PostDataSettings.location' $location
