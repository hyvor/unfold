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
    Run this docker image inside a docker container. Make sure to bind the port <strong>7272</strong>
    with a prefered port to access unfold endpoints.
</p>

<CodeBlock
    code={`
    docker run -d -p 7272:7272 hyvor/unfold:latest
    `}
/>

<p>
    Now you can access Unfold endpoints.
</p>

<h2 id="endpoints">Endpoints</h2>

<h3>Unfold Endpoint</h3>

<CodeBlock
    language='ts'
    code={`
    Method: GET
    URL: 'http://127.0.0.1:7272/unfold'

    Query Parameters:
        url: string
        method: link | embed | null   // default: link

    Response:
        {
            url: string,
            lastUrl: string,
            title: string | null,
            description: string | null,
            siteName: string | null,
            siteUrl: string | null,
            canonicalUrl: string | null,
            publishedTime: string | null,
            modifiedTime: string | null,
            thumbnailUrl: string | null,
            iconUrl: string | null,
            locale: string | null,
            authors: string[],
            tags: string[],
            durationMs: number
        }

    Example: 'http://127.0.0.1:7272/unfold?url=https://hyvor.com.com&method=link'
    `}
/>

<h3>Iframe Endpoint</h3>

<CodeBlock
    language='ts'
    code={`
    Method: GET
    URL: 'http://127.0.0.1:7272/iframe'

    Query Parameters:
        url: string
    
    Response:
        {
            url: string,
            embed: string,
            durationMs: number
        }

    Example: 'http://127.0.0.1:7272/iframe?url=https%3A%2F%2Fwww.youtube.com%2Fwatch%3Fv%3DdQw4w9WgXcQ'
    `}
/>

<p>
    You can find more details about <code>iframe endpoint</code> <a href="/iframe">here</a>.
</p>