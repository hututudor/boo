bash build.sh
aws s3 sync public s3://boo.tudorhutu.ro
aws cloudfront create-invalidation --distribution-id E1IX7QO230T09T --paths '/*' >> /dev/null