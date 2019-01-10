<footer id="footer" class="ui footer center aligned basic segment" role="contentinfo">
    <div class="ui text container">
        <div>
            &copy; {{ date('Y') }} <a href="{{ route('home') }}">{{ setting('title', config('app.name')) }}</a>.
        </div>

        <div>
            <span class="developed-by">Developed By <span>Luff</span></span>,&nbsp;
            <span class="powered-by">Powered By <span>Laravel</span></span>.
        </div>
    </div>
</footer>