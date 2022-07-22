import copy
import os
import shutil
import inspect

document_list = []

filename = inspect.getframeinfo(inspect.currentframe()).filename
path_file_exe     = os.path.dirname(os.path.abspath(filename))
for path, subdirs, files in os.walk(path_file_exe):
	for name in files:
		if os.path.splitext(os.path.join(path,name))[1] == ".pdf":
			document_list.append(os.path.join(path,name))

document_list2 = copy.copy(document_list)
range_list = len(document_list)
for i in range(0, range_list):
	slesh_num = document_list[i].rfind('\\')
	real_file_name = document_list[i][slesh_num + 1: len(document_list[i])]
	document_list[i] = document_list[i][0:slesh_num]
	slesh_num = document_list[i].rfind('\\')
	document_list[i] = document_list[i][0:slesh_num + 1] + real_file_name
	shutil.copyfile(r''+document_list2[i], r''+document_list[i])


