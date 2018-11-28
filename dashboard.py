"""
Created on Tue Nov 28 20:59:55 2017

@author: abhiram haridas (abhiramharidas@gmail.com)
"""


"""

This is the main file for the admin console application. The menu for the main program can be found at the end of this file.
Separate functions like edit_home, edit_about etc handles editing the respective pages of the website.

This file imports from dash_utils.py which is a set of utility functions. The main program expects admin-csea.json file to
be available in the working directory. 

Conventions Followed

db_ref_string : The template string which when substituted gives the actual reference string to a specific database node
db_ref : The actual reference to the database object
blob_ref_string : The template string which when substituted gives the actual reference string to a specific storage location
blob : The actual reference to the storage object

All network operations have been enclosed in try blocks. If any of them fails due to any unknown reasons, a network
error message is displayed. Actual error stack trace can be obtained by slightly modifying network_error method in this file.

A small description of each function is available at the beginning of each function.
"""

import firebase_admin
from firebase_admin import credentials
from firebase_admin import db
from firebase_admin import storage

import sys
import traceback
import json
from datetime import datetime
import dash_utils
import os

cred = credentials.Certificate('./admin-csea.json')           #authenticating with the database

firebase_admin.initialize_app(cred, {
    'databaseURL': 'https://cseanitcweb.firebaseio.com',
    'storageBucket': 'cseanitcweb.appspot.com'
   
})

bucket = storage.bucket()                                     # Reference to the storage bucket



# This functions displays an error message and exits. This can be edited to view error stack trace. The program exits after the message.

def network_error():

	print "\nUnable to read/write data  Check your internet connection and try again. If connection is alright modify source to view stacktrace.\n"
	
	# print "\n The traceback for the error occurred\n"    #*********** Uncomment this part to view stack trace of the error ***********
	# traceback.print_exc()
	# print "\n\n"

	sys.exit()



# Function for editing the home page including slider images, right pane, cneter pane and upcoming events

def edit_home():
	
	while(1):

		print("\nEnter 1 to edit slider images")
		print("Enter 2 to edit right pane")
		print("Enter 3 to edit center pane ")
		print("Enter 4 to add upcoming event")
		print("Enter 5 to exit")
	
		choice = raw_input()

		try:
			choice = int(choice)
		except ValueError:
			print "\nError! Invalid input.\n"
			continue
			

		if(choice == 1):

			db_ref_string = 'home/slider'
			blob_ref_string = 'home/slider/%s'

			file1 = raw_input("Enter path to image1 : ")
			file2 = raw_input("Enter path to image2 : ")
			file3 = raw_input("Enter path to image3 : ")

			error_flag, error_msg = dash_utils.file_exist(file1)
			if (error_flag == 1):
				print "\nError! Path to image1 does not exist.\n"
				continue

			error_flag, error_msg = dash_utils.file_exist(file2)
			if (error_flag == 1):
				print "\nError! Path to image2 does not exist.\n"
				continue

			error_flag, error_msg = dash_utils.file_exist(file3)
			if (error_flag == 1):
				print "\nError! Path to image3 does not exist.\n"
				continue

			
			try:
				blob = bucket.blob(blob_ref_string % "1")
				blob.upload_from_filename(file1)
			except:
				network_error()
			
			try:
				blob = bucket.blob(blob_ref_string % "2")
				blob.upload_from_filename(file2)
			except:
				network_error()

			try:
				blob = bucket.blob(blob_ref_string % "3")
				blob.upload_from_filename(file3)
			except:
				network_error()

			try:
				db_ref = db.reference(db_ref_string)
			
				slider_data = {
					'1': blob_ref_string % "1",
					'2': blob_ref_string % "2",
					'3': blob_ref_string % "3"
				}

			except:
				network_error()

		elif(choice == 2):

			db_ref_string = 'home'

			html = raw_input("Enter right pane html : ")
			
			try:
				db_ref = db.reference(db_ref_string)
				db_ref.update({
					'right_pane' : html
					})
			except:
				network_error()

		elif(choice == 3):

			db_ref_string = 'home'

			html = raw_input("Enter center pane html : ")
			
			try:
				db_ref = db.reference(db_ref_string)
				db_ref.update({
					'center_pane' : html
					})
			except:
				network_error()

		elif(choice == 4):

			db_ref_string = 'home/upcoming/%s/%s'         # home/upcoming/year/title

			title = raw_input("\nEnter activity title : ")
			short_desc = raw_input("Enter very short description (max 10 words) : ")
			date = raw_input("Enter date (dd/mm/yyyy) : ")

			error_flag, error_msg = dash_utils.check_name(title)
			if (error_flag == 1):
				print error_msg
				return
		
			error_flag, error_msg = dash_utils.check_date(date)
			if (error_flag == 1):
				print error_msg
				return


			date = date.split('/')

			data = {

				'title': title,
				'short_desc': short_desc,
				'date' : {
					'day': date[0],
					'month' : date[1],
					'year' : date[2]
				}
			}

			try:
				db_ref = db.reference (db_ref_string % (date[2],title))
				db_ref.set(data)
			except:
				network_error

			print "\nEvent added successfully\n"

			
		elif(choice == 5):
			return

		else :
			print("Invalid Input")


# Function for editing About page

def edit_about():

	db_ref_string = 'about'

	try:
		db_ref = db.reference(db_ref_string)
	except:
		network_error()

	while(1):

		print("\nEnter 1 to edit About Us")
		print("Enter 2 to edit Vision")
		print("Enter 3 to edit How we Work")
		print("Enter 4 to edit Join us")
		print("Enter 5 to exit")
	
		choice = raw_input()
		
		try:
			choice = int(choice)
		except ValueError:
			print "\nError! Invalid input.\n"
			continue	
	
		if(choice == 1):
			html = raw_input('Enter about html : ')
			
			try:
				db_ref.update({
					'about' : html
					})
			except:
				network_error()

		elif(choice == 2):
			html = raw_input('Enter vision html : ')

			try:
				db_ref.update({
					'vision' : html
					})
			except:
				network_error()

		elif(choice == 3):
			html = raw_input('Enter how we work html : ')
			
			try:
				db_ref.update({
					'how' : html
					})
			except:
				network_error()

		elif(choice == 4):
			html = raw_input('Enter join us html : ')			

			try:
				db_ref.update({
					'join_us' : html
					})
			except:
				network_error()

		elif(choice == 5):
			return
		else :
			print("Invalid input")



# Function for adding members and toggling flag_for_inductions

def edit_members():

	while(1):

		print ("\nEnter 1 to add faculty")
		print ("Enter 2 to add student")
		print ("Enter 3 to toggle flag_for_inductions")
		print ("Enter 4 to exit")

		choice = raw_input()
		
		try:
			choice = int(choice)
		except ValueError:
			print "\nError! Invalid input.\n"
			continue

		if(choice == 1):

			db_ref_string = 'members/faculty/%s'
			blob_ref_string = 'members/faculty/%s'

			name = raw_input("\nEnter name : ")
			email = raw_input("Enter email : ")
			file_dir = raw_input("Enter path to image : ")

			error_flag, error_msg = dash_utils.check_name(name)
			if (error_flag == 1):
				print error_msg
				continue

			error_flag, error_msg = dash_utils.file_exist(file_dir)
			if (error_flag == 1):
				print error_msg
				continue

			try:
				blob = bucket.blob(blob_ref_string % name)
				blob.upload_from_filename(file_dir) 
	
				db_ref = db.reference(db_ref_string % name)
	
				user_data = {
					'nameof' : name,
					'email' : email,
					'img' : blob_ref_string % name
				}
	
				db_ref.set(user_data)
			except:
				network_error()

		elif(choice == 2):

			db_ref_string = 'members/students/%(category)s/%(year)s/%(name)s'
			blob_ref_String = 'members/students/%(category)s/%(year)s/%(name)s'

			name = raw_input("\nEnter student name : ")
			year = raw_input("Enter student admission year : ")
			email = raw_input("Enter student email : ")
			linkedin = raw_input("Enter linkedin profile : ")
			file_dir = raw_input("Enter path to image file : ")

			ch = raw_input("Enter 1 for BTech, 2 for MTech and 3 for MCA : ")
			try:
				ch = int(ch)
			except ValueError:
				print "\nError! Invalid input.\n"
				continue

			error_flag, error_msg = dash_utils.check_name(name)
			if (error_flag == 1):
				print error_msg
				continue

			error_flag, error_msg = dash_utils.check_year(year)
			if (error_flag == 1):
				print error_msg
				continue

			if ch == 1:
				category = 'btech'
			elif ch == 2:
				category = 'mtech'
			else:	
				category = 'mca'

			userdata = {
				'nameof': name,
				'email':email,
				'linkedin':linkedin,
				'img': db_ref_string % {'year': year, 'category': category, 'name': name}	
			}

			error_flag, error_msg = dash_utils.file_exist(file_dir)
			if (error_flag == 1):
				print error_msg
				continue

			try:			
				blob = bucket.blob(blob_ref_String % {'year': year, 'category': category, 'name': name})
				blob.upload_from_filename(file_dir)	
				
				db_ref = db.reference(db_ref_string % {'year': year, 'category': category, 'name': name})
				db_ref.set(userdata)
			except:
				network_error()
				
			

		elif(choice == 3):
			
			db_ref_string = 'members/flag_for_inductions'

			try:
				db_ref = db.reference(db_ref_string)
				val = db_ref.get()

				if val == 0:
					db_ref.set(1)
					print('Value toggled: Current value is 1')
				else:
					db_ref.set(0)
					print('Value toggled: Current value is 0')
				
			except:
				network_error()


		elif(choice == 4):
			return;
		else:
			print "Invalid input"


# Function to add an activity

def edit_activity():

	db_ref_string = 'activities/%s/%s'
	blob_ref_string = 'activities/%s/%s'

	title = raw_input("\nEnter activity title : ")
	short_desc = raw_input("Enter short decsription : ")
	long_desc = raw_input("Enter long description : ")
	date = raw_input("Enter date (dd/mm/yyyy) : ")
	file_dir = raw_input("Enter path to image : ")
	
	choice = raw_input("Enter 1 for Course/Workshop, 2 for talk or 3 for others : ")
	
	try:
		choice = int(choice)
	except ValueError:
		print "\nError! Invalid input.\n"
		return

	error_flag, error_msg = dash_utils.check_name(title)
	if (error_flag == 1):
		print error_msg
		return

	error_flag, error_msg = dash_utils.check_date(date)
	if (error_flag == 1):
		print error_msg
		return


	date = date.split('/')
	category = 'others'

	if(choice == 1):
		category = 'workshop'
	elif(choice == 2):
		category = 'talk'

	data = {
		'title' : title,
		'short_desc' : short_desc,
		'long_desc' : long_desc,
		'date' : {
					'day': date[0],
					'month' : date[1],
					'year' : date[2]
				},
		'category' : category,
		'img' : blob_ref_string % (date[2],title)

	}

	error_flag, error_msg = dash_utils.file_exist(file_dir)
	if (error_flag == 1):
		print error_msg
		return

	try:
		blob = bucket.blob(blob_ref_string % (date[2],title) )
		blob.upload_from_filename(file_dir)
	
		db_ref = db.reference(db_ref_string % (date[2],title) )
		db_ref.set(data)
	except:
		network_error()


# Function to add an event to gallery

def edit_gallery():

	db_ref_string = 'gallery/%s/%s'                                # gallery/<year>/<event_name>
	blob_ref_string = 'gallery/%s/%s/%s'                           # gallery/<year>/<event_name>/<img_no>

	title = raw_input("\nEnter activity title : ")
	short_desc = raw_input("Enter short decsription : ")
	date = raw_input("Enter date (dd/mm/yyyy) : ")
	img_count = raw_input("Enter image count : ")
	drive_link = raw_input("Enter drive link : ")

	error_flag, error_msg = dash_utils.check_name(title)
	if (error_flag == 1):
		print error_msg
		return

	error_flag, error_msg = dash_utils.check_date(date)
	if (error_flag == 1):
		print error_msg
		return

	date = date.split('/')

	data = {
		'title' : title,
		'short_desc' : short_desc,
		'date' : {
					'day': date[0],
					'month' : date[1],
					'year' : date[2]
				},
		'img_count' : img_count,
		'drive_link' : drive_link
	}


	img_count = int(img_count)
	i = 1
	img = {}

	img_parent_dir = raw_input("Enter folder with the %s images : " %str(img_count))
	
	error_flag, error_msg = dash_utils.check_file_count(img_parent_dir,img_count)
	
	if(error_flag == 1):
		print error_msg
	
	for img_name in sorted(os.listdir(img_parent_dir)):
		img_dir = str(os.path.join(img_parent_dir, img_name))
		print(img_dir)
		error_flag, error_msg = dash_utils.file_exist(img_dir)
		if (error_flag == 1):
			print error_msg
			continue

		try:
			blob = bucket.blob(blob_ref_string % (date[2],title,str(i)) )
			blob.upload_from_filename(img_dir)
		except:
			network_error()

		img[i] = blob_ref_string % (date[2],title,str(i))
		i = i + 1;

	data['img'] = img

	try:
		db_ref = db.reference(db_ref_string % (date[2], title) )
		db_ref.set(data)
	except:
		network_error()


# Function to edit the contents of the notice box

def edit_notice():

	db_ref_string = 'notice_box'
	html = raw_input("\nEnter notice box html : ")

	try:
		db_ref = db.reference(db_ref_string)
		db_ref.set(html)
	except:
		network_error()


# Function to backup/restore all HTML fileds in the database. Backup/Restore is done using backup_html.txt file in the working directory.

def backup_restore_html():

	print("\nEnter 1 to backup HTML fields")
	print("Enter 2 restore HTML fileds")
	print("Enter 3 to exit")	
	
	choice = raw_input()
	
	try:
		choice = int(choice)
	except ValueError:
		print "\nError! Invalid input.\n"
		return

	if choice == 1:

		try:
			notice_box_ref = db.reference('notice_box')
			right_pane_ref = db.reference('home/right_pane')
			center_pane_ref = db.reference('home/center_pane')
			about_ref = db.reference('about')

			notice_box = notice_box_ref.get()
			right_pane = right_pane_ref.get()
			center_pane = center_pane_ref.get()
			about = about_ref.get()
			date = datetime.now().strftime('%d-%m-%Y %H:%M:%S')

		except:
			network_error()

		backup = {
			'notice_box' : notice_box,
			'right_pane' : right_pane,
			'center_pane' : center_pane,
			'about' : about,
			'date' : date
			};

		try:
			with open('./backup_html.txt','w') as backup_file:
				json.dump(backup,backup_file)
		except:
			print ("\nError! Could not create backup file. Make sure working directory is read-only.\n\n")
			return


		print("\nBackup written to backup_html.txt on %s\n\n" % date)

	elif choice == 2:

		try:
			with open('./backup_html.txt','r') as backup_file:
				backup = json.load(backup_file)
		except:
			print ("\nError! Backup file appears to be missing or corrupted.\n\n")
			return

		try:
			notice_box_ref = db.reference('notice_box')
			right_pane_ref = db.reference('home/right_pane')
			center_pane_ref = db.reference('home/center_pane')
			about_ref = db.reference('about')

			notice_box_ref.set(backup['notice_box'])
			right_pane_ref.set(backup['right_pane'])
			center_pane_ref.set(backup['center_pane'])
			about_ref.set(backup['about'])
		except:
			network_error()

		print("\nRestored backup from %s\n\n" % backup['date'])

	else :
		print("Invalid Input")






#============================================   MAIN FUNCTION STARTS HERE ===================================================


choice = 0
print ("Welcome to the Admin console!\n\n")

while(choice != 8):	
	
	print ("\nEnter 1 to edit Home Page")
	print ("Enter 2 to edit About Page")
	print ("Enter 3 to edit Members Page")
	print ("Enter 4 to edit Activities Page")
	print ("Enter 5 to edit Gallery")
	print ("Enter 6 to edit Notice HTML")
	print ("Enter 7 to backup/restore HTML fields")
	print ("Enter 8 to exit")
	
	choice = raw_input()
	
	try:
		choice = int(choice)
	except ValueError:
		print "\nError! Invalid input.\n"
		choice = 0
		continue
	
	
	if(choice == 1):
		edit_home()
	elif(choice == 2):
		edit_about()
	elif(choice == 3):
		edit_members()
	elif(choice == 4):
		edit_activity()
	elif(choice == 5):
		edit_gallery()
	elif(choice == 6):
		edit_notice()
	elif(choice == 7):
		backup_restore_html()
	elif(choice == 8):
		continue;
	else:
		print "\nError! Invalid input.\n"
