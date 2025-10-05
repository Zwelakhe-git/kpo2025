from django.db import models

# Create your models here.

class Image(models.Model):
    id = models.BigAutoField(primary_key=True)
    location = models.CharField(max_length=300, unique=True)
    mime_type = models.CharField(max_length=256, null=True)

    class Meta:
        verbose_name_plural = "Images"


class Video(models.Model):
    id = models.BigAutoField(primary_key=True)
    vid_img = models.ForeignKey(to=Image, to_field="id", null=True, on_delete=models.SET_NULL)
    vid_title = models.CharField(max_length=200, null=True)
    location = models.CharField(max_length=300, null=False)
    mime_type = models.CharField(max_length=256)

    class Meta:
        verbose_name_plural = "videos"

    def __str__(self):
        return self.vid_title

class Service(models.Model):
    id = models.BigAutoField(primary_key=True)
    name = models.CharField(max_length=50, null=False)
    service_img = models.ForeignKey(to=Image, to_field="id", null=True, on_delete=models.SET_NULL)

    class Meta:
        verbose_name_plural = "Services"

class News(models.Model):
    id = models.BigAutoField(primary_key=True)
    news_img = models.ForeignKey(to=Image, to_field="id", null=True, on_delete=models.SET_NULL)
    news_title = models.TextField()

    class Meta:
        verbose_name_plural = "News"

