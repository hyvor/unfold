<script>
	import { CodeBlock } from "@hyvor/design/components";

</script>
<h1>Docker Hosting</h1>

<p>
    Unfold is available as a Docker image. You can run it on your own server or use a cloud service.
    Unfold Docker Image provides all the endpoints including the iframe endpoint. You can simply use 
    Unfold by running the Docker image.
</p>

<h2 id="docker">Setting up a Docker Container</h2>

<p>You can pull Unfold Docker Image into your server by running the following command.</p>

<CodeBlock
    code={`
    docker pull hyvor/unfold:latest
    `}
/>

<p>
    Run this docker image inside a docker container. Make sure to bind the port <strong>5050</strong>
    with a prefered port to access unfold endpoints.
</p>

<CodeBlock
    code={`
    docker run -d -p <preferred-port>:5050 hyvor/unfold:latest
    `}
/>

<p>
    Now you can access Unfold endpoints.
</p>

<CodeBlock
    code={`
    https://example.com:<preferred-port>/unfold?url=https://url-to-unfold.com&method=link
    `}
/>

<CodeBlock
    code={`
    https://example.com:<preferred-port>/iframe?url=https://url-to-embed.com
    `}
/>