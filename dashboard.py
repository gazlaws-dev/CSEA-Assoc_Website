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


print ("Welcome to the Admin console!\n\n")

print ("Enter 1 to edit Home Page")
print ("Enter 2 to edit About Page")

choice = raw_input()
choice = int(choice)


if(choice == 1):
	edit_home()
elif(choice == 2):
	edit_about()
