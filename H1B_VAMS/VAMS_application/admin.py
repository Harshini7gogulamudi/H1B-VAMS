from django.contrib import admin
from .models import *

# Register your models here.

admin.site.register(UserDatabase)
admin.site.register(Applications)
admin.site.register(Feedback)