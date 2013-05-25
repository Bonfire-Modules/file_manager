Bonfire-Filemanager
===================

A Module to handle files and uploads for CI-Bonfire.

-----------------------------------------------------------------------

## Road Map

Check out our online [road map](https://trello.com/board/file-manager/51a12c111ea77c6f79007df9) where you can comment and vote on items in the lists.

## More info
Longer text about the plugin.

## Functions
- Fileupload / multi-fileupload
- Filemanager / uploaded files view

## Settings
- Maxfilesize
- Uploaddir
- Use file/link

## Features

- Inproved dataTable with sort, search and more.
- Manage files
- Search function
- replace file (all with option ”on all or current”)
- change filename
- delete file (all with option ”on all or current”)
- option to only use random link for download (security feature)
- indication on change file page: how manny other links it has
- indication on activity
- Manage filesystem
- View files without link → generate random link for files


## DB Schema (remove when implemented and point to migration file)

# file
- id
- checksum    	(sha1) 
- filesize				
- modified
- created

# file_alias
- id
- file_id
- name
- slug/url
- description
- tags
- public
- owner_id
- modified
- created

## The Team

- [inbe](https://github.com/inbe) - Lead Developer
- [Janne-](https://github.com/Janne-) - Lead Developer
