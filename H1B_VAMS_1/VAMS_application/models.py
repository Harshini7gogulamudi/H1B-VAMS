from django.db import models
from django.db.models import Model
from django.contrib.auth.models import User

# Create your models here.

class UserDatabase(Model):

    userOptions = [
        ('employee', 'employee'),
        ('employer', 'employer'),
        ('admin', 'admin')
    ]

    gender_options = [
        ('male', 'male'),
        ('female', 'female'),
        ('other', 'other')
    ]

    user = models.OneToOneField(User, on_delete=models.CASCADE)
    role = models.CharField(max_length=10, choices=userOptions, blank=True)
    gender = models.CharField(max_length=10, choices=gender_options, blank=False)
    organization = models.CharField(max_length=1000, blank=True, default='No Information Available')
    educationalBackground = models.CharField(max_length=100, blank=True, default='No Information Available')
    userProfileImage = models.FileField(upload_to='uploads/', blank=False)
    
    def __str__(self):
        return f"Full Name - {self.user.get_full_name()} | Email - {self.user.email} | Role - {self.role} | Gender - {self.gender} | User Image - {self.userProfileImage.url} |\
                Educational background - {self.educationalBackground} | Organization - {self.organization} "

class Applications(Model):

    status = [
        ('In-Progress', 'inprogress'),
        ('Approved', 'approved'),
        ('Rejected', 'rejected')
    ]

    gender_options = [
        ('male', 'male'),
        ('female', 'female'),
        ('other', 'other')
    ]

    passportNumber = models.CharField(max_length=10, blank=False)
    fullName = models.CharField(max_length=100, blank=False)
    organization = models.CharField(max_length=50, blank=False)
    jobTitle = models.CharField(max_length=50, blank=False)
    jobCategory = models.CharField(max_length=50, blank=False)
    gender = models.CharField(max_length=10, choices=gender_options, blank=False)
    applicationStatus = models.CharField(max_length=20, choices=status, blank=False)
    submittedBy = models.ForeignKey(UserDatabase, on_delete=models.CASCADE)

    def __str__(self):
        return f'Passport Number - {self.passportNumber} | Full Name - {self.fullName} | Organization - {self.organization} | Job Title - {self.jobTitle} | \
                    Job Category - {self.jobCategory} | Gender - {self.gender} | Application Status - {self.applicationStatus} |\
                        Submitted By - {self.submittedBy.user.get_full_name()}'

class Feedback(Model):
    
    ratingChoices = [(str(count+1), count+1) for count in range(5)]

    application = models.OneToOneField(Applications, on_delete=models.CASCADE)
    feedback = models.CharField(max_length=1000, blank=False)
    rating = models.CharField(max_length=1, choices=ratingChoices)

    def __str__(self):
        return f"Application ID - {self.application} | Feedback - {self.feedback} | Rating - {self.rating} "