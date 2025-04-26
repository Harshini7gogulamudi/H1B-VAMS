from django.shortcuts import render, redirect
from django.http import HttpResponseRedirect
from django.contrib.auth.decorators import login_required
from django.contrib.auth import authenticate, login, logout
from django.contrib.auth.models import User
from .models import *

# Create your views here.

def index(request):

    return render(request, "login.html")

def registration(request):
    
    if request.method == 'GET':
        
        return render(request, 'registration.html')

    elif request.method == 'POST':
        pass

def employee(request, name):
    ...


def employeeUpdate(request, name):
    ...


def employer(request, name, orgName):
    ...


def applicationForm(request, name, orgName):
    ...


def employerUpdate(request, name, orgName):
    ...


def employeeRegistration(request, name, orgName):
    ...


def employerFeedback(request, name, orgName):
    ...


def adminPage(request, name, orgName):
    ...


def employerRegistration(request, name, orgName):
    ...
