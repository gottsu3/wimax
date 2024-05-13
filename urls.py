# urls.py

from django.urls import path
from . import views

urlpatterns = [
    path('verify_captcha/', views.verify_captcha, name='verify_captcha'),
    # Dodaj inne trasy URL tutaj, jeśli potrzebujesz
]
