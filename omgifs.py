#!/usr/bin/python
import praw
import time
import mimetypes
import MySQLdb
import thread


total_gifs = 0;

def input_func():
	while True:
		input_data = raw_input('')
		if "Show" in input_data:
			if "#Gifs" in input_data:
				print(total_gifs)

thread.start_new_thread(input_func, ())

db = MySQLdb.connect(host='localhost', user='root', passwd='FireFromFarts', db='omgifs')
cursor = db.cursor()

mimetypes.init()


r	= praw.Reddit(user_agent='omgifs by /u/eldhom , https://firecan.org/omgifs/')
subreddit = r.get_subreddit('gifs')

while True:
	if db.open:
		db = MySQLdb.connect(host='localhost', user='root', passwd='FireFromFarts', db='omgifs')
		cursor = db.cursor()
	cursor.execute("TRUNCATE TABLE links")
	submissions = subreddit.get_hot(limit=600)
	added_links = 0
	for submission in submissions:
		if added_links == 300:
			time.sleep(1800)
			break
		if submission.domain == 'i.imgur.com' or 'image/gif' in mimetypes.guess_type(submission.url):
			if submission.over_18 == True:
				continue
			try:
				cursor.execute("INSERT INTO links VALUES (%s, %s, %s)", (submission.url, submission.title.encode('ascii', 'ignore'), added_links))
				db.commit()
				added_links += 1
			except:
				db.rollback()
			
			total_gifs += 1
			print("ID: " + str(added_links) + "URL: " + str(submission.url))

