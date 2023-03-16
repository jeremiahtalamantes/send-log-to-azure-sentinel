# send-log-to-azure-sentinel
This will send log data to Azure Sentinel using the Azure Log Analytics Workspace REST API.
# Usage
Replace `your_workspace_id` and `your_shared_key` with your actual Workspace ID and Shared Key. The sendLogData function accepts a JSON string containing the log data that you want to send to Azure Sentinel. The example above demonstrates sending a single log entry, but you can send multiple entries by preparing an array of log data and converting it to a JSON string.

For more information on how to do this, please refer to the official Azure documentation: https://docs.microsoft.com/en-us/azure/azure-monitor/logs/quick-create-workspace

# Description
In order to send application log data to Azure Sentinel using Azure's REST API, you'll first need to create a Log Analytics Workspace and obtain the required credentials (Workspace ID and Shared Key). For more information on how to do this, please refer to the official Azure documentation: https://docs.microsoft.com/en-us/azure/azure-monitor/logs/quick-create-workspace

