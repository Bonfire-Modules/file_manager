Bonfire-Filemanager
===================

A Module to handle files and uploads for CI-Bonfire.

-----------------------------------------------------------------------

# Fileupload / multi-fileupload
## Settings
- maxfilesize
- uploaddir

## Features
- Multifile (simultanius upload of multiple files)
- Drag and drop aka. Drop-box
- Create DB->file row when needed, linking to file if fileexists (via md5/sha1 checksum)
- Create DB->file_alias

# Filemanager / uploaded files view

## Settings
- maxfilesize
- uploaddir
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




## DB Schema

# file
- id
- checksum    	(md5/sha1) 
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
