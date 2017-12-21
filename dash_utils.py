
"""
Created on Tue Nov 28 20:59:55 2017

@author: abhiram haridas (abhiramharidas@gmail.com)
"""

import os.path


#================================================== HELPER FUNCTIONS FOR ERROR HANDLING ====================================================

#Functions generally return two values - error_flag and error_msg. error_flag will be set if there is an error and corresponding error
#message will be contained in error_msg

def file_exist(file_name):            
    
    error_flag = 0
    error_msg = ""
    
    if (not os.path.isfile(file_name)):
        error_flag = 1
        error_msg = "\nError! The specified file does not exist\n"
        
    return (error_flag,error_msg)


def check_date(date_string):

	error_flag = 0
	error_msg = ""

	dates = date_string.split('/');

	if(len(dates) != 3):
		error_flag = 1;
		error_msg = "\nError! Invalid date string. Please follow the specified format.\n"
		return (error_flag, error_msg)

	t = dates[0];                                                                               # validating day

	try:
		t = int(t)
	except ValueError:
		error_flag = 1;
		error_msg = "\nError! Invalid day in date string provided.\n"
		return (error_flag, error_msg)

	if(t < 1 or t > 31):

		error_flag = 1;
		error_msg = "\nError! Invalid day in date string provided.\n"
		return (error_flag, error_msg)

	t = dates[1]                                                                               # validating month       

	try:
		t = int(t)
	except ValueError:
		error_flag = 1;
		error_msg = "\nError! Invalid month in date string provided.\n"
		return (error_flag, error_msg)

	if(t < 1 or t > 12):

		error_flag = 1;
		error_msg = "\nError! Invalid month in date string provided.\n"
		return (error_flag,error_msg)

	t = dates[2]                                                                               # validating year

	try:
		t = int(t)
	except ValueError:
		error_flag = 1;
		error_msg = "\nError! Invalid month in date string provided.\n"
		return (error_flag, error_msg)

	if(t < 1997 or t > 2100):        # :) :P

		error_flag = 1;
		error_msg = "\nError! Invalid month in date string provided.\n"
		return (error_flag, error_msg)


	return (error_flag, error_msg)                                          # valid date


def check_year(year_str):

	error_flag = 0
	error_msg = ""

	try:
		year = int(year_str)
	except ValueError:
		error_flag = 1
		error_msg = "\nError! Invalid year provided.\n"
		return (error_flag, error_msg)

	if (year < 1997 or year > 2100):

		error_flag = 1;
		error_msg = "\nError! Invalid month in date string provided.\n"

	return (error_flag, error_msg)


def check_name(name_str):


	error_flag = 0
	error_msg = ""

	name = name_str.replace(' ','')

	if not name.isalpha():

		error_flag = 1
		error_msg = "\nError! Name should have alphabets and spaces only.\n"

	return (error_flag, error_msg)
	


#========================================== Functions executed when executed as main file ========================================

def remove_linebreaks(file_name):

	error_flag, error_msg = file_exist(file_name)

	if error_flag == 1:
		print error_msg
		return None

	with open(file_name) as myfile:
		data = myfile.read()


	return data.replace('\n','').replace('\r','')


if __name__ == '__main__':
	
	file_name = raw_input("Enter path to file : ")
	data_str = remove_linebreaks(file_name)
	
	if data_str is not None:
		print data_str













        
    
    
    