from django.shortcuts import render

from .models import Service, Image
# Create your views here.

def index(request):
    services = Service.objects.order_by("id")
    context = { "services" : services }
    return render(request, 'konektem/index.html', context)

def styles(request, filename):
    return render(request, f"konektem/CSS/{filename}", content_type="text/css")
