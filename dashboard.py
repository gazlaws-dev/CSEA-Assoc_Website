import firebase_admin
from firebase_admin import credentials
from firebase_admin import db
from firebase_admin import storage

cred = credentials.Certificate('./admin.json')
firebase_admin.initialize_app(cred, {
    'databaseURL': 'https://hello-firebase-847fe.firebaseio.com',
    'storageBucket': 'hello-firebase-847fe.appspot.com'
})

bucket = storage.bucket()

def edit_home():
	
	while(1):

		print("\nEnter 1 to edit slider images")
		print("Enter 2 edit right pane")
		print("Enter 3 to exit")
	
		choice = raw_input()
		choice = int(choice)

		if(choice == 1):

			db_ref_string = 'home/slider'
			blob_ref_string = 'home/slider/%s'

			file1 = raw_input("Enter path to image1 : ")
			file2 = raw_input("Enter path to image2 : ")
			file3 = raw_input("Enter path to image3 : ")
			
			blob = bucket.blob(blob_ref_string % "1")
			blob.upload_from_filename(file1)

			blob = bucket.blob(blob_ref_string % "2")
			blob.upload_from_filename(file2)

			blob = bucket.blob(blob_ref_string % "3")
			blob.upload_from_filename(file3)

			db_ref = db.reference(db_ref_string)

			slider_data = {
				'1': blob_ref_string % "1",
				'2': blob_ref_string % "2",
				'3': blob_ref_string % "3"
			}

			db_ref.set(slider_data)

		elif(choice == 2):

			db_ref_string = 'home'

			html = raw_input("Enter right pane html : ")
			
			db_ref = db.reference(db_ref_string)
			db_ref.update({
				'right_pane' : html
				})

		elif(choice == 3):
			return

		else :
			print("Invalid Input")



def edit_about():

	db_ref_string = 'about'
	db_ref = db.reference(db_ref_string)

	while(1):

		print("\nEnter 1 to edit About Us")
		print("Enter 2 to edit Vision")
		print("Enter 3 to edit How we Work")
		print("Enter 4 to edit Join us")
		print("Enter 5 to exit")
	
		choice = raw_input()
		choice = int(choice)	
	
		if(choice == 1):
			html = raw_input('Enter about html : ')
			db_ref.update({
				'about' : html
				})
		elif(choice == 2):
			html = raw_input('Enter vision html : ')
			db_ref.update({
				'vision' : html
				})
		elif(choice == 3):
			html = raw_input('Enter how we work html : ')
			db_ref.update({
				'how' : html
				})
		elif(choice == 4):
			html = raw_input('Enter join us html : ')
			db_ref.update({
				'join_us' : html
				})
		elif(choice == 5):
			return
		else :
			print("Invalid input")



def edit_members():

	while(1):

		print ("\nEnter 1 to add faculty")
		print ("Enter 2 to add student")
		print ("Enter 3 to exit")

		choice = raw_input()
		choice = int(choice)

		if(choice == 1):

			db_ref_string = 'members/faculty/%s'
			blob_ref_string = 'members/faculty/%s'

			name = raw_input("\nEnter name : ")
			email = raw_input("Enter email : ")
			file_dir = raw_input("Enter path to image : ")

			blob = bucket.blob(blob_ref_string % name)
			blob.upload_from_filename(file_dir) 

			db_ref = db.reference(db_ref_string % name)

			user_data = {
				'nameof' : name,
				'email' : email,
				'img' : blob_ref_string % name
			}

			db_ref.set(user_data)

		elif(choice == 2):

			db_ref_string = 'members/students/%(year)s/%(category)s/%(name)s'
			blob_ref_String = 'members/students/%(year)s/%(category)s/%(name)s'

			name = raw_input("\nEnter student name : ")
			year = raw_input("Enter student admission year : ")
			email = raw_input("Enter student email : ")
			linkedin = raw_input("Enter linkedin profile : ")
			file_dir = raw_input("Enter path to image file : ")

			ch = raw_input("Enter 1 for BTech, 2 for MTech and 3 for MCA : ")
			ch = int(ch)

			if ch == 1:
				category = 'btech'
			elif ch == 2:
				category = 'mtech'
			else:	
				category = 'mca'

			userdata = {
				'name': name,
				'email':email,
				'linkedin':linkedin,
				'img': db_ref_string % {'year': year, 'category': category, 'name': name}	
			}

			blob = bucket.blob(blob_ref_String % {'year': year, 'category': category, 'name': name})
			blob.upload_from_filename(file_dir)

			db_ref = db.reference(db_ref_string % {'year': year, 'category': category, 'name': name})
			db_ref.set(userdata)

		elif(choice == 3):
			return;
		else:
			print "Invalid input"





print ("Welcome to the Admin console!\n\n")

print ("Enter 1 to edit Home Page")
print ("Enter 2 to edit About Page")
print ("Enter 3 to edit Members Page")

choice = raw_input()
choice = int(choice)


if(choice == 1):
	edit_home()
elif(choice == 2):
	edit_about()
elif(choice == 3):
	edit_members()