#! /bin/sh

# Get the instance ID from Amazon AWS endpoint and save in env variable
INSTANCEID=$(curl --silent http://169.254.169.254/latest/meta-data/instance-id)
export INSTANCEID

exit 0