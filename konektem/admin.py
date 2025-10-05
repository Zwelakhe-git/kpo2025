from django.contrib import admin

# Register your models here.
from .models import *

admin.site.register(Image)
admin.site.register(Service)
admin.site.register(Video)
admin.site.register(News)
