typedef void *thread_t;
thread_t create();
void emplace(thread_t w, void(*fn)());
void start(thread_t w);