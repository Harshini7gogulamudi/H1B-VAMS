"""
URL configuration for H1B_VAMS project.

The `urlpatterns` list routes URLs to views. For more information please see:
    https://docs.djangoproject.com/en/5.2/topics/http/urls/
Examples:
Function views
    1. Add an import:  from my_app import views
    2. Add a URL to urlpatterns:  path('', views.home, name='home')
Class-based views
    1. Add an import:  from other_app.views import Home
    2. Add a URL to urlpatterns:  path('', Home.as_view(), name='home')
Including another URLconf
    1. Import the include() function: from django.urls import include, path
    2. Add a URL to urlpatterns:  path('blog/', include('blog.urls'))
"""
from django.contrib import admin
from django.urls import path
from django.conf import settings
from django.conf.urls.static import static
from VAMS_application.views import *

urlpatterns = [
    path('admin/', admin.site.urls),
    path('', index, name='login'),
    path('registration/', registration, name='registration'),
    path('logout/', logout, name='logout'),
    path('employee/<str:name>', employee, name='employee_page'),
    path('employee/<str:name>/update information', employeeUpdate, name='employee_update_info'),
    path('employer/<str:name>/<str:orgName>/', employer, name='employer_page'),
    path('employer/<str:name>/<str:orgName>/application form/', applicationForm, name='application_form'),
    path('employer/<str:name>/<str:orgName>/update information/', employerUpdate, name='employer_update_info'),
    path('employer/<str:name>/<str:orgName>/employee registration/', employeeRegistration, name='employee_registration'),
    path('employer/<str:name>/<str:orgName>/feedback/', employerFeedback, name='employer_feedback'),
    path('adminPage/<str:name>/', adminPage, name='admin_panel'),
    path('adminPage/<str:name>/employer registration', employerRegistration, name='employer_registration')

] + static(settings.MEDIA_URL, document_root = settings.MEDIA_ROOT)
