from django.shortcuts import render, redirect
from django.http import HttpResponseRedirect
from django.urls import reverse, reverse_lazy
from django.contrib.auth.decorators import login_required
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.models import User
from .models import *

# Create your views here.

def index(request):

    if request.method == "GET":
        return render(request, "login.html")

    elif request.method == "POST":

        username = request.POST.get('username', '')
        password = request.POST.get('password', '')

        if(username != '' and password != ''):
            user = authenticate(request, username=username, password=password)

            if user is not None:
                login(request, user)

                userobject = UserDatabase.objects.get(user=user)
                
                role = userobject.role
                
                print(role)
                print(userobject)

                match role:
                    case 'employee':
                        fullname = userobject.user.get_full_name()
                        return redirect('employee_page', name=fullname)
                    
                    case 'employer':
                        fullname = userobject.user.get_full_name()
                        orgname = userobject.organization
                        return redirect('employer_page', name=fullname, orgName=orgname)
                    
                    case 'admin':
                        fullname = userobject.user.get_full_name()
                        return redirect('admin_panel', name=fullname)

            return HttpResponseRedirect(reverse('login'))
        else:
            return render(request, 'login.html', {'class': 'text text-center text-danger', 'message': 'Try again!'})
            

def registration(request):
    
    if request.method == 'GET':
        
        return render(request, 'registration.html')

    elif request.method == 'POST':
        
        fullName = request.POST.get('full_name', '')
        email = request.POST.get('email', '')
        password = request.POST.get('password', '')
        gender = request.POST.get('gender', '')
        userImage = request.FILES.get('image', '')

        try:
            firstname, lastname = str(fullName).split(' ')
            user = User.objects.create_user(username = firstname, email = email, password = password, first_name = firstname, last_name = lastname)
            user.save()

            userdatabase = UserDatabase(user=user, gender=gender, userProfileImage=userImage)
            userdatabase.save()

            return HttpResponseRedirect(reverse('login'))

        except:
            return render(request, 'registration.html', {'class': 'text text-center text-danger', 'message': 'Try again!'})

def logoutPage(request):
    logout(request)
    return render(request, 'logout.html')


@login_required(login_url="/")
def employee(request, name):
    
    first_name, last_name = name.split(' ')
    
    application = Applications.objects.get(fullName = name)

    if request.method == "GET":
        return render(request, 'applicant/application_status.html', {'employee_name': first_name, 'application_status': application.applicationStatus})


@login_required(login_url="/")
def employeeUpdate(request, name):
    first_name = name.split(' ')[0]
    
    user = User.objects.get(first_name = first_name)
    userObject = UserDatabase.objects.get(user = user)

    email = user.email

    educationalBackground = userObject.educationalBackground

    if request.method == "GET":
        return render(request, 'applicant/update_information.html', {'employee_name': name, 'employee_email': email, 'educationalBackground': educationalBackground})

    elif request.method == "POST":
        
        fullName = request.POST.get('full_name', '')
        email = request.POST.get('email', '')
        educationalBackground = request.POST.get('education', '')
        password = request.POST.get('password', '')

        if(password == ''):
            try:
                first_name, last_name = fullName.split(' ')
                user.first_name = first_name
                user.last_name = last_name
                user.email = email
                userObject.educationalBackground = educationalBackground

                user.save()
                print('user saved')
                userObject.save()


                return redirect('employee_page', name=user.get_full_name())

            except:
                return render(request,'applicant/update_information.html', {'class': 'text text-center text-danger', 'message': 'Try Again!',\
                                                                            'employee_name': name, 'employee_email': email, 'educationalBackground': educationalBackground})
                
        else:
            try:
                first_name, last_name = fullName.split(' ')
                user.first_name = first_name
                user.last_name = last_name
                user.email = email
                user.set_password(password)
                userObject.educationalBackground = educationalBackground

                user.save()
                userObject.save()

                return redirect('employee_page', name=user.get_full_name())

            except:
                return render(request,'applicant/update_information.html', {'text text-center text-danger': 'Try Again!'})
                

@login_required(login_url="/")
def employer(request, name, orgName):

    first_name = name.split(" ")[0]

    user = User.objects.get(username = first_name)

    userObject = UserDatabase.objects.get(user=user, organization = orgName)

    try:
        applications = Applications.objects.filter(submittedBy=userObject, organization=orgName)
        
        print(applications)

        if request.method == "GET":
            return render(request, "employer/employer_index.html", {'applications': applications})

    except:
        return render(request, "employer/employer_index.html")


@login_required(login_url="/")
def applicationForm(request, name, orgName):
    
    if request.method == "GET":
        return render(request, 'employer/application_form.html')

    elif request.method == "POST":

        first_name, last_name = name.split(' ')

        user = User.objects.get(first_name=first_name, last_name=last_name)

        userObject = UserDatabase.objects.get(user = user, role='employer')

        passport_number = request.POST.get('passport_number')
        full_name = request.POST.get('full_name')
        job_title = request.POST.get('job_title')
        job_category = request.POST.get('job_category')
        gender = request.POST.get('gender')
        organization_name = orgName
        application_status = 'In-Progress'
        application_submitted_by = userObject

        try:
            application = Applications( passportNumber = passport_number,
                                        fullName = full_name,
                                        organization = organization_name,
                                        jobTitle = job_title,
                                        jobCategory = job_category,
                                        gender = gender,
                                        applicationStatus = application_status,
                                        submittedBy = application_submitted_by
                                    )
            
            application.save()

            return redirect('employer_page', name=name, orgName=orgName)
        
        except:
            return render(request, 'employer/application_form.html')


@login_required(login_url="/")
def employerUpdate(request, name, orgName):
    first_name = name.split(' ')[0]
    
    user = User.objects.get(first_name = first_name)
    userObject = UserDatabase.objects.get(user = user, role='employer')

    email = user.email

    if request.method == "GET":
        return render(request, 'employer/change_password.html', {'employer_name': name, 'employer_email': email})

    elif request.method == "POST":
        
        fullName = request.POST.get('full_name', '')
        email = request.POST.get('email', '')
        educationalBackground = request.POST.get('education', '')
        password = request.POST.get('password', '')

        if(password == ''):
            try:
                first_name, last_name = fullName.split(' ')
                user.first_name = first_name
                user.last_name = last_name
                user.email = email

                user.save()
                print('user saved')
                userObject.save()


                return redirect('employer_page', name=user.get_full_name())

            except:
                return render(request,'employer/change_password.html', {'class': 'text text-center text-danger', 'message': 'Try Again!',\
                                                                            'employer_name': name, 'employer_email': email})
                
        else:
            try:
                first_name, last_name = fullName.split(' ')
                user.first_name = first_name
                user.last_name = last_name
                user.email = email
                user.set_password(password)

                user.save()
                userObject.save()

                return redirect('employer_page', name=user.get_full_name())

            except:
                return render(request,'employer/change_password.html', {'text text-center text-danger': 'Try Again!'})
              


@login_required(login_url="/")
def employeeRegistration(request, name, orgName):
    
    if request.method == "GET":
        return render(request, "employer/employee_registration.html")

    elif request.method == "POST":
        full_name = request.POST.get('full_name') 
        email = request.POST.get('email') 
        organisation = request.POST.get('organisation') 

        first_name, last_name = full_name.split(' ')

        try:
            user = User.objects.get(email = email, first_name=first_name, last_name=last_name)
            userObject = UserDatabase.objects.get(user=user)
            userObject.organization = organisation
            userObject.role = 'employee'

            userObject.save()

            return redirect('employer_page', name=name, orgName=orgName)
        except:
            return render(request, "employer/employee_registration.html")
        

@login_required(login_url="/")
def employerFeedback(request, name, orgName):
    if request.method == "GET":
        
        return render(request, 'employer/feedback.html')

    elif request.method == "POST":
        
        return render(request, 'employer/feedback.html')


@login_required(login_url="/")
def adminPage(request, name):
    if request.method == "GET":
        
        allApplications = list()

        for application in Applications.objects.all():
            
            if(application.applicationStatus != "Approved" and application.applicationStatus != "Rejected"):
                allApplications.append(application)
            else:
                continue
        
        print(allApplications)

        return render(request, 'adminPanel/index.html', {'applications': allApplications})

    elif request.method == "POST":
        
        actionResults = request.POST.get('action', '')

        application_id, action = actionResults.split(' ')

        print(application_id, action)
        try:
            application = Applications.objects.get(id = application_id)
            application.applicationStatus = action

            application.save()

            return redirect('admin_panel', name=name)
        except:
            return render(request, "adminPanel/index.html", {'class': 'text text-center text-danger', 'message': 'Try Again!'})


@login_required(login_url="/")
def employerRegistration(request, name):
    
    if request.method == "GET":
        return render(request, "adminPanel/employer_registration.html")

    elif request.method == "POST":
        full_name = request.POST.get('full_name') 
        email = request.POST.get('email') 
        organisation = request.POST.get('organisation') 

        first_name, last_name = full_name.split(' ')

        try:
            user = User.objects.get(email = email, first_name=first_name, last_name=last_name)
            userObject = UserDatabase.objects.get(user=user)
            userObject.organization = organisation
            userObject.role = 'employer'

            userObject.save()

            return redirect('admin_panel', name=name)
        except:
            return render(request, "adminPanel/employer_registration.html")