from django.urls import path

from . import views

app_name = "konektem"

urlpatterns = [
    path('', views.index, name="index"),
    path('css/<str:filename>', views.styles, name="styles")
]